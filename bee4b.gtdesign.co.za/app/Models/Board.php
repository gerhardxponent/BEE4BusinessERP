<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Board extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name','red_flagged'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_board');
    }

    public function boardItems()
    {
        return $this->hasMany(BoardItem::class);
    }

    public function files()
    {
        return $this->belongsToMany(File::class, 'board_files');
    }

    public function boardable()
    {
        return $this->morphTo();
    }

    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }

    public function consultant()
    {
        return $this->belongsTo(User::class, 'consultant_id');
    }

    public function analyst()
    {
        return $this->belongsTo(User::class, 'analyst_id');
    }

    public function jnrAnalyst()
    {
        return $this->belongsTo(User::class, 'jnrAnalyst_id');
    }

    protected $casts = [
        'red_flagged' => 'boolean',
    ];

}
