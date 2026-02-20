<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditReference extends Model
{
    use HasFactory;

    public function files()
    {
        return $this->hasMany(AuditFile::class, 'audit_reference_id');
    }

    public function folder()
    {
        return $this->belongsTo(AuditReferenceCategory::class, 'folder_id');
    }

    public function audits()
    {
        return $this->belongsToMany(Audit::class, 'audit_has_audit_refs');
    }

    public function responsible_person()
    {
        return $this->belongsTo(User::class, 'responsible_person_id');
    }

    protected $fillable = ['name', 'folder_id', 'audit_id', 'default'];

    public function scopeActive($q) 
    { 
        return $q->where('is_active', 1); 
    }
}
