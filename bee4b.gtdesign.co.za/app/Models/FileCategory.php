<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileCategory extends Model
{
    use HasFactory;

    public function attributes()
    {
        return $this->morphMany(Attribute::class, 'attributable');
    }

    public function files()
    {
        return $this->hasMany(File::class, 'category_id');
    }
}
