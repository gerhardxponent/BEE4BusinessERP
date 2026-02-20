<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditReferenceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'top_level'
    ];

    // Relationship: Get Parent (Top-Level Category)
    public function topLevelCategory()
    {
        return $this->belongsTo(AuditReferenceCategory::class, 'top_level');
    }

    // Relationship: Get Sub-Categories (Child Categories)
    public function subCategories()
    {
        return $this->hasMany(AuditReferenceCategory::class, 'top_level');
    }

    public function referenceItems()
    {
        return $this->hasMany(AuditReference::class, 'folder_id')
        ->where('is_active', 1);
    }

    public function references()
    {
        return $this->referenceItems();
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', 1);
    }
}
