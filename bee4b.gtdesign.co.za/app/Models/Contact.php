<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'jobtitle', 
        'email',
        'phone_primary', 
        'phone_secondary',
        'category'
    ];

    // public function client()
    // {
    //     return $this->belongsTo(Clients::class, 'client_id');
    // }
    public function contactable()
    {
        return $this->morphTo();
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'activityable');
    }

    // public function firstname()
    // {
    //     return $this->firstname;
    // }

    public function managementProcesses()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
