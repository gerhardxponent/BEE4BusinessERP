<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'primary_phone',
        'secondary_phone',
        'email_address',
        'company_name',
        'website',
        'sector_id',
        'enquiry'
    ];

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'activityable')->orderByDesc('activities.id');
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }

    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function consultable()
    {
        return $this->morphMany(Consultation::class, 'consultable');
    }

    public function boards()
    {
        return $this->morphMany(Board::class, 'boardable');
    }

    public function board_categories()
    {
        return $this->morphMany(BoardItemCategory::class, 'categoryable');
    }
}
