<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'position'
    ];

    public function clients()
    {
        return $this->hasMany(Clients::class, 'sector');
    }
}
