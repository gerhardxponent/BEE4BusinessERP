<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceCategory extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function icon()
    {
        return $this->belongsTo(Icon::class, 'icon_id');
    }

    public function resources()
    {
        return $this->hasMany(Resource::class, 'resource_category_id');
    }
}
