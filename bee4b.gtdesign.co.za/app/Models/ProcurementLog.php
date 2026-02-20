<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcurementLog extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'date_allocated', 'due_date', 'scorecard_number', 'notes'
    ];

    public function client()
    {
        return $this->belongsTo(Clients::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function ppAnalyst()
    {
        return $this->belongsTo(User::class, 'pp_analyst_id', 'id');
    }

    public function board()
    {
        return $this->belongsTo(Board::class, 'board_id');
    }
}
