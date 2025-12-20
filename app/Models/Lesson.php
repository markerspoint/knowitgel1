<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'content',
        'thumbnail',
        'status'
    ];

     /**
     * The users who have completed this lesson.
     */
    public function completedByUsers()
    {
        return $this->belongsToMany(User::class, 'lesson_user', 'lesson_id', 'user_id')
                    ->withPivot('completed_at')
                    ->withTimestamps();
    }

    /**
     * Check if the lesson has been completed by a specific user (or the authenticated user).
     *
     * @param User|null $user
     * @return bool
     */
    public function isCompletedBy(User $user = null): bool
    {
        if (is_null($user)) {
            $user = Auth::user();
        }

        if (!$user) {
            return false;
        }

        return $this->completedByUsers()->where('user_id', $user->id)->exists();
    }

    /**
     * Get the completion record for a specific user (or the authenticated user).
     *
     * @param User|null $user
     * @return \Illuminate\Database\Eloquent\Relations\Pivot|null
     */
    public function getCompletionRecord(User $user = null)
    {
        if (is_null($user)) {
            $user = Auth::user();
        }

        if (!$user) {
            return null;
        }
        
        return $this->completedByUsers()->where('user_id', $user->id)->first()->pivot ?? null;
    }
}