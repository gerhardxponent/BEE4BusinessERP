<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(UserReport::class, 'user_report');
    }

    public function scheduledReports()
    {
        return $this->hasMany(ScheduledReport::class);
    }
}
