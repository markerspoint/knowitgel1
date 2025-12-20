<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function game()
    {
        
        $lessons = Lesson::where('status', 'active')
                         ->with(['completedByUsers' => function ($query) {
                             $query->where('user_id', Auth::id());
                         }])
                         ->get();
        
        return view('lesson.game', compact('lessons'));
    }

    /**
     * Display the specified lesson.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson)
    {
        
        $lesson->load(['completedByUsers' => function ($query) {
            $query->where('user_id', Auth::id());
        }]);
        return view('lesson.show', compact('lesson'));
    }

    /**
     * Mark the specified lesson as complete for the authenticated user.
     *
     * @param  \App\Models\Lesson  $lesson
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function markAsComplete(Request $request, Lesson $lesson)
    {
        $user = Auth::user();

        if ($user && !$lesson->isCompletedBy($user)) {
            $user->completedLessons()->attach($lesson->id, ['completed_at' => now()]);
            return redirect()->route('lesson.show', $lesson)->with('success', 'Lesson marked as complete!');
        }

        return redirect()->route('lesson.show', $lesson)->with('info', 'Lesson already completed or unable to mark as complete.');
    }
}
