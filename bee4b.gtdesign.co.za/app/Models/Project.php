<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name',
        'project_category',
        'project_description',
        'target_start_date',
        'target_end_date',
        'actual_start_date',
        'actual_end_date',
        'client_id',
        'user_id'
    ];
}
