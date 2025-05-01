<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['instructor_id', 'content', 'attachments'];
    public $timestamps = false;
    protected $casts = [
        'attachments' => 'array',
        'created_at' => 'timestamp'
    ];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function getAttachmentUrlsAttribute()
    {
        if (empty($this->attachments)) {
            return [];
        }

        return array_map(function ($attachment) {
            return [
                'name' => $attachment['name'],
                'url' => Storage::url($attachment['path'])
            ];
        }, $this->attachments);
    }
}
