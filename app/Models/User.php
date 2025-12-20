<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'fname',
        'lname',
        'username',
        'email',
        'number',
        'password',
        'role',
        'is_disabled',
        'profile_picture',
    ];

    protected $hidden = [
        'password',
        'remember_token',
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

    public function assessments()
    {
        return $this->hasMany(UserAssessment::class);
    }

    public function hasCompletedAssessment()
    {
        return $this->assessments()->exists();
    }
}
