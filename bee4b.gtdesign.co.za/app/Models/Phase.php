<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    use HasFactory;

    protected $fillable = [
        'position',
    ];

    public function items()
    {
        return $this->hasMany(BoardItem::class);
    }

    public function defaultItems()
    {
        return $this->hasMany(DefaultTask::class, 'phase_id');
    }
}
