<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagementProcess extends Model
{
    use HasFactory;

    public $displayName = 'Management';

    protected $fillable = ['name'];

    public function boards()
    {
        return $this->morphMany(Board::class, 'boardable');
    }

    public function board_categories()
    {
        return $this->morphMany(BoardItemCategory::class, 'categoryable');
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'activityable');
    }
    
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function contacts()
    {
        return $this->morphMany(Contact::class, 'contactable');
    }

    public function icon()
    {
        return $this->belongsTo(Icon::class, 'icon_id');
    }
}
