<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditExcelBackup extends Model
{
    use HasFactory;

    public function audit()
    {
        return $this->belongsTo(Audit::class, 'audit_id');
    }

    public function files()
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}
