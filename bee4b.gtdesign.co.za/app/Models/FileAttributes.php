<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileAttributes extends Model
{
    use HasFactory;

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
