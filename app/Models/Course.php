<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'level_id',
        'instructor_id'
    ];
    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }
    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
