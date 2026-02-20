<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultTask extends Model
{
    use HasFactory;

    protected $fillable = ['position'];

    public function parent()
    {
        return $this->belongsTo(DefaultTask::class, 'parent_id');
    }

    public function subTasks()
    {
        return $this->hasMany(DefaultTask::class, 'parent_id');
    }

    public function priorityForeign()
    {
        return $this->belongsTo(Priority::class, 'priority_id');
    }
}
