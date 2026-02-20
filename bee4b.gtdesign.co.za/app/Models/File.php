<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'file_name', 'type', 'file_size', 'file_path', 'file_size', 'isBackup'
    ];

    public function fileable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Clients::class);
    }

    public function boards()
    {
        return $this->belongsToMany(Board::class, 'board_files');
    }

    public function category()
    {
        return $this->belongsTo(FileCategory::class, 'category_id');
    }

    public function attributes()
    {
        return $this->hasMany(FileAttributes::class);
    }

    public function fileDetails()
    {
        return $this->hasOne(AuditFile::class, 'file_id', 'id');
    }
}
