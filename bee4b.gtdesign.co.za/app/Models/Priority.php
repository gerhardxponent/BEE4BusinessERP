<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    use HasFactory;

    public function boardItems()
    {
        return $this->hasMany(BoardItem::class, 'priority_id');
    }
}
