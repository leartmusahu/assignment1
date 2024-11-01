<?php 
namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'instructor_id' => 'required|exists:users,id', 
        ]);
    
       
        $course = Course::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'instructor_id' => $validatedData['instructor_id'],
        ]);
    
        return response()->json($course, 201);
    }

    public function enroll(Request $request, $courseId)
    {
       
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id', 
        ]);

       
        $course = Course::findOrFail($courseId);

        
        $course->users()->attach($validatedData['user_id']);

        return response()->json(['message' => 'User enrolled successfully.'], 200);
    }
    
    public function destroy($id)
{
    $course = Course::find($id);

    if (!$course) {
        return response()->json(['message' => 'Course not found.'], 404);
    }
    $course->delete();
    return response()->json(['message' => 'Course deleted successfully.']);
}

}
