<?php

namespace App\Models;

use App\Events\BoardItemStatusChanged;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardItem extends Model
{
    use HasFactory;

    public $displayName = 'Task';

    protected $fillable = [
        'position', 'status', 'status_id', 'status_position', 'completed_at',
    ];

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_board_items', 'boardItem_id');
    }

    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'user_board_items', 'boardItem_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'board_item_tags', 'boardItem_id');
    }

    // public function comments()
    // {
    //     return $this->hasMany(BoardItemComment::class);
    // }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function phase()
    {
        return $this->belongsTo(Phase::class, 'phase_id');
    }

    public function category()
    {
        return $this->belongsTo(BoardItemCategory::class);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function parent()
    {
        return $this->belongsTo(BoardItem::class, 'parent_id');
    }

    public function subTasks()
    {
        return $this->hasMany(BoardItem::class, 'parent_id');
    }

    public function priorityForeign()
    {
        return $this->belongsTo(Priority::class, 'priority_id');
    }

    //Named getResponsiblePerson to work with wire:model
    public function getResponsiblePerson()
    {
        return $this->belongsTo(User::class, 'responsible_person');
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'activityable');
    }

    public function consultable()
    {
        return $this->morphMany(Consultation::class, 'consultable');
    }

    public function getStatus()
    {
        return $this->belongsTo(TaskStatus::class, 'status_id');
    }
}
