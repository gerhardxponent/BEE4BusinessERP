<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class BoardPermission extends Model
{
    use HasFactory;

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}
