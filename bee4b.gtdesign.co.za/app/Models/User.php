<?php

namespace App\Models;

use CreateBoardItemsTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'client_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'enabled' => 'boolean',

    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function files()
    {
        return $this->hasMany(File::class);
    }

    // Handy scopes
    public function scopeEnabled($q)
    {
        return $q->where('enabled', 1);
    }
    public function scopeDisabled($q)
    {
        return $q->where('enabled', 0);
    }
    public function scopeEnabledIf($q, $includeDisabled = false)
    {
        return $includeDisabled ? $q : $q->enabled();
    }

    public function reports()
    {
        return $this->belongsToMany(UserReport::class, 'user_reports');
    }

    public function boards()
    {
        return $this->belongsToMany(Board::class, 'user_board');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function managingClients()
    {
        return $this->hasMany(Clients::class, 'manager');
    }

    public function analysingClients()
    {
        return $this->hasMany(Clients::class, 'analyst');
    }

    public function responsibleTasks()
    {
        return $this->hasMany(BoardItem::class, 'responsible_person');
    }

    public function startedChats()
    {
        return $this->hasMany(Chat::class, 'user1_id');
    }

    public function participatingChats()
    {
        return $this->hasMany(Chat::class, 'user2_id');
    }

    public function allChats()
    {
        // $started = $this->startedChats();
        // $participating = $this->participatingChats();

        // $all = $started->union($participating);
        // dd($this->startedChats->merge($this->participatingChats));
        // return $all;

        return $this->startedChats->merge($this->participatingChats);
    }

    public function auditMailList()
    {
        return $this->morphedByMany(Audit::class, 'mailable');
    }

    public function contact()
    {
        return $this->hasOne(Contact::class);
    }

    public function chats()
    {
        return $this->belongsToMany(Chat::class, 'user_chats');
    }

    public function resources()
    {
        return $this->hasMany(Resource::class, 'user_id');
    }

    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }
}
