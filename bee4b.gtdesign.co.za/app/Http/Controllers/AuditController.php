<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Audit;
use App\Models\AuditReferenceCategory;
use App\Models\User;
use Mail;
use App\Models\AuditFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AuditController extends Controller
{
    public function sendSummaryReport()
    {
        $audits = Audit::all(); // Fetch all audits

        foreach ($audits as $audit) {
            // Reuse the logic from the working `getDataProperty`
            $categories = AuditReferenceCategory::query()
                ->with([
                    'referenceItems' => function ($query) use ($audit) {
                        $query
                            ->whereHas('audits', function ($query) use ($audit) {
                                $query->where('audit_has_audit_refs.audit_id', $audit->id);
                            })
                            ->where(function ($query) use ($audit) {
                                $query->where('audit_references.audit_id', $audit->id)
                                    ->orWhere('audit_references.audit_id', null);
                            });
                    },
                    'referenceItems.files' => fn($query) => $query->where('audit_files.audit_id', $audit->id),
                    'referenceItems.files.checkedByUser',
                    'referenceItems.files.fileDetails.user'
                ])
                ->get();

            // Fetch Client users linked to this audit's client_id
            $clientEmails = User::where('client_id', $audit->client_id)
                ->whereHas('roles', fn($query) => $query->where('name', 'Client'))
                ->pluck('email')
                ->toArray();

            // Ensure xiiphoid@gmail.com is CCed
            $ccEmails = ['xiiphoid@gmail.com'];

            // Combine client emails and cc emails
            $toEmails = $clientEmails ?: $ccEmails; // Use CC emails if no clients found

            // Prepare the email data
            $emailData = [
                'audit' => $audit,
                'categories' => $categories,
            ];

            // Send the email
            Mail::send('emails.audit-summary', $emailData, function ($message) use ($toEmails, $ccEmails) {
                $message->to($toEmails)
                    ->cc($ccEmails)
                    ->subject('Audit Summary Report');
            });
        }

        return 'Summary emails have been sent!';
    }

    public function getAuditData($auditId)
    {
        // 1) Per-reference status counts (based on earliest file per reference)
        $countRows = DB::select(<<<SQL
            SELECT
                CASE
                    WHEN ff.status = 0 THEN 'pending'
                    WHEN ff.status = 1 THEN 'accepted'
                    WHEN ff.status = 2 THEN 'rejected'
                    WHEN ff.status = 3 THEN 'empty'
                    ELSE 'empty'
                END AS status_label,
                COUNT(*) AS cnt
            FROM (
                SELECT audit_reference_id, MIN(id) AS first_id
                FROM audit_files
                WHERE audit_id = ?
                GROUP BY audit_reference_id
            ) p
            JOIN audit_files ff ON ff.id = p.first_id
            GROUP BY status_label
        SQL, [$auditId]);

        $counts = collect($countRows)->mapWithKeys(fn($r) => [$r->status_label => (int)$r->cnt]);

        $totalAccepted = $counts['accepted'] ?? 0;
        $totalPending  = $counts['pending']  ?? 0;
        $totalRejected = $counts['rejected'] ?? 0;
        $totalEmpty    = $counts['empty']    ?? 0;

        // Per-reference uploaded total (exclude "empty")
        $totalFiles = $totalAccepted + $totalPending + $totalRejected;

        // 2) Per-reference list rows for the PDF (again: earliest file per reference)
        $files = DB::select(<<<SQL
            SELECT 
                ar.name                         AS name,
                COALESCE(u.name, rp.name)       AS uploadedBy,
                ff.created_at                   AS dateUploaded,
                ff.status                       AS status,
                arc.top_level                   AS top_level,
                arc.name                        AS section
            FROM (
                SELECT audit_reference_id, MIN(id) AS first_id
                FROM audit_files
                WHERE audit_id = ?
                GROUP BY audit_reference_id
            ) p
            JOIN audit_files ff           ON ff.id = p.first_id
            LEFT JOIN files f             ON ff.file_id = f.id
            LEFT JOIN users u             ON f.user_id = u.id           -- uploader
            LEFT JOIN users rp            ON ff.responsible_person_id = rp.id
            LEFT JOIN audit_references ar ON ar.id = ff.audit_reference_id
            LEFT JOIN audit_reference_categories arc ON arc.id = ar.folder_id
            ORDER BY arc.top_level, arc.name, ar.name
        SQL, [$auditId]);

        // Split by status for the PDF sections
        $pendingFiles  = array_values(array_filter($files,  fn($r) => (int)$r->status === 0));
        $acceptedFiles = array_values(array_filter($files,  fn($r) => (int)$r->status === 1));
        $rejectedFiles = array_values(array_filter($files,  fn($r) => (int)$r->status === 2));
        $emptyFiles    = array_values(array_filter($files,  fn($r) => (int)$r->status === 3));

        return response()->json([
            'totalFiles'    => $totalFiles,
            'totalAccepted' => $totalAccepted,
            'totalPending'  => $totalPending,
            'totalRejected' => $totalRejected,
            'totalEmpty'    => $totalEmpty,
            'pendingFiles'  => $pendingFiles,
            'acceptedFiles' => $acceptedFiles,
            'rejectedFiles' => $rejectedFiles,
            'emptyFiles'    => $emptyFiles,
        ]);
    }


    public function sendAuditReport(Request $request)
    {
        // Validate file upload
        if (!$request->hasFile('pdf')) {
            return response()->json(['message' => 'No PDF uploaded'], 400);
        }

        // Get audit ID from request
        $auditId = $request->input('audit_id');

        if (!$auditId) {
            return response()->json(['message' => 'Audit ID is missing'], 400);
        }

        // Fetch the client's email using a custom SQL query
        $clientData = DB::select("
            SELECT clients.email, clients.name 
            FROM audits 
            JOIN clients ON audits.client_id = clients.id 
            WHERE audits.id = ?
            LIMIT 1
        ", [$auditId]);

        // Check if we got a result
        if (!$clientData || empty($clientData[0]->email)) {
            return response()->json(['message' => 'Client email not found'], 404);
        }

        $clientEmail = $clientData[0]->email;
        $clientName = $clientData[0]->name;

        // override email
        $clientEmail = $this->parseEmailList($request->input('to', ''));

        //return response()->json(['message' => 'Client:'.$clientEmail], 400);

        $body = "Please find the attached audit report.";

        // Store the PDF temporarily
        $pdfPath = storage_path("app/public/Audit_Report_{$auditId}.pdf");
        $request->file('pdf')->move(storage_path('app/public'), "Audit_Report_{$auditId}.pdf");

        // Send email with the PDF
        Mail::send([], [], function ($message) use ($pdfPath, $body, $clientEmail, $clientName) {
            $message->to($clientEmail)
                ->cc(["xiiphoid@gmail.com", "reg@bee4business.co.za"])
                ->subject("Audit Report")
                ->attach($pdfPath, [
                    'as' => "Audit_Report.pdf",
                    'mime' => 'application/pdf',
                ])
                ->setBody("Dear ".$clientName.",<br/>".$body, 'text/html');
        });

        return response()->json(['message' => 'PDF emailed successfully']);
    }

    /**
 * Turn a comma/semicolon/space-separated list (or array) into a
 * unique, validated array of emails.
 */
    private function parseEmailList($raw): array
    {
        if (is_array($raw)) {
            $candidates = $raw;
        } else {
            // split on comma, semicolon, or whitespace
            $candidates = preg_split('/[,\s;]+/', (string) $raw, -1, PREG_SPLIT_NO_EMPTY);
        }

        $emails = [];
        foreach ($candidates as $val) {
            $val = trim($val);
            if ($val !== '' && filter_var($val, FILTER_VALIDATE_EMAIL)) {
                $emails[] = strtolower($val);
            }
        }
        return array_values(array_unique($emails));
    }

}
