<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function enroll(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $course = Course::find($request->course_id);
        $course->users()->attach($request->user_id);

        return response()->json(['message' => 'User enrolled successfully.']);
    }
}
