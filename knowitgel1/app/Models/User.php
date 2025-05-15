<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'fname', 'lname', 'username', 'email', 'number', 'password',
    ];

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function completedLessons()
    {
        return $this->belongsToMany(Lesson::class, 'lesson_user', 'user_id', 'lesson_id')
                    ->withPivot('completed_at')
                    ->withTimestamps();
    }
}
