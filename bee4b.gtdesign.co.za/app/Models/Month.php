<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    use HasFactory;

    public function clients()
    {
        return $this->hasMany(Clients::class, 'planned_audit_month_id');
    }
}
