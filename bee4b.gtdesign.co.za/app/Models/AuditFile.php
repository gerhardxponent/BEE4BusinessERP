<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_requested', 'due_date', 'date_last_checked', 'notes'
    ];

    public function reference()
    {
        return $this->belongsTo(AuditReference::class, 'audit_reference_id');
    }

    public function fileDetails()
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function checkedByUser()
    {
        return $this->belongsTo(User::class, 'checked_by');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'activityable');
    }

    // public function auditReference()
    // {
    //     return $this->belongsTo(AuditReference::class, 'audit_reference_id');
    // }
}
