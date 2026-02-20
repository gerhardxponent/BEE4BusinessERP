<?php

namespace App\Exports;

use App\Models\Activity;
use App\Models\Audit;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AuditExport implements FromView
{
    public $data;
    public $auditDetails;

    public function __construct($data, $auditDetails)
    {
        $this->data = $data;
        $this->auditDetails = $auditDetails;
    }

    public function view(): View
    {
        return view('exports.audit', [
            'data' => $this->data,
            'auditDetails' => $this->auditDetails,
        ]);
    }
}
