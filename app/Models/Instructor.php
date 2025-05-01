<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'department'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
