<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public function boardItems()
    {
        return $this->belongsToMany(BoardItem::class, 'board_item_tags');
    }

    public function colour()
    {
        return $this->belongsTo(Colour::class, 'colour_id');
    }
}
