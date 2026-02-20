<?php
// app/Models/AuditTemplate.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditTemplate extends Model
{
    protected $fillable = ['name'];

    public function fields()
    {
        return $this->belongsToMany(
            AuditReference::class,
            'audit_template_fields',
            'template_id',
            'reference_id'
        )->withTimestamps();
    }
}
