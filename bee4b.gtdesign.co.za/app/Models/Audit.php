<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Board;

class Audit extends Model
{
    use HasFactory;
    use SoftDeletes;

    // protected $fillable = [
    //     'name'
    // ];

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function auditFiles()
    {
        return $this->hasMany(AuditFile::class, 'audit_id');
    }

    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }

    public function board()
    {
        return $this->belongsTo(Board::class, 'board_id');
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'activityable');
    }

    public function audit_references()
    {
        return $this->belongsToMany(AuditReference::class, 'audit_has_audit_refs');
    }

    public function mailList()
    {
        return $this->morphToMany(User::class, 'mailable');
    }

    protected array $progressCache = [];

    /**
     * Latest-audit progress for a given client (percentages, rounded ints).
     * Caches per request so Blade can call it per row without extra DB chatter.
     */
    public function auditProgressFor(int $clientId): array
    {
        if (isset($this->progressCache[$clientId])) {
            return $this->progressCache[$clientId];
        }

        // Adjust these if your status codes differ
        $STATUS_APPROVED = 1;
        $STATUS_PENDING = 0;
        $STATUS_REJECTED = 2;

        $audit = Audit::with([
            'auditFiles' => function ($q) {
                $q->select('id', 'audit_id', 'status', 'file_id');
            }
        ])
            ->where('client_id', $clientId)
            ->latest()
            ->first();

        if (!$audit) {
            return $this->progressCache[$clientId] = ['approved' => 0, 'pending' => 0, 'rejected' => 0];
        }

        $files = $audit->auditFiles->filter(fn($f) => !is_null($f->file_id));
        $total = $files->count();

        if ($total === 0) {
            return $this->progressCache[$clientId] = ['approved' => 0, 'pending' => 0, 'rejected' => 0];
        }

        $approved = $files->where('status', $STATUS_APPROVED)->count();
        $pending = $files->where('status', $STATUS_PENDING)->count();
        $rejected = $files->where('status', $STATUS_REJECTED)->count();

        $pct = fn($n, $d) => (int) round($n / $d * 100);

        return $this->progressCache[$clientId] = [
            'approved' => $pct($approved, $total),
            'pending' => $pct($pending, $total),
            'rejected' => $pct($rejected, $total),
        ];
    }
}
