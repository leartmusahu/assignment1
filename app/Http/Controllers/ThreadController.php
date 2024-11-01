<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Reply;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function create(Request $request)
{
    $validatedData = $request->validate([
        'course_id' => 'required|integer',
        'instructor_id' => 'required|integer',
        'title' => 'required|string|max:255',
        'body' => 'required|string',
    ]);

    $thread = Thread::create($validatedData);

    return response()->json($thread, 201);
}

    
    
    public function delete(Request $request, $id)
    {
        $thread = Thread::findOrFail($id);
        // Check if the authenticated user is the instructor
        if (auth()->user()->id === $thread->instructor_id) {
            $thread->delete();
            return response()->json(['message' => 'Thread deleted successfully.']);
        }
    
        return response()->json(['message' => 'Unauthorized.'], 403);
    }
    
    public function reply(Request $request)
{
    $request->validate([
        'thread_id' => 'required|exists:threads,id',
        'user_id' => 'required|exists:users,id',
        'content' => 'required|string',
    ]);

    $reply = Reply::create([
        'thread_id' => $request->thread_id,
        'user_id' => $request->user_id,
        'content' => $request->content,
    ]);

    return response()->json(['message' => 'Reply created successfully.', 'reply' => $reply], 201);
}

    
    public function deleteReply(Request $request, $id)
    {
        $reply = Reply::findOrFail($id);
        // Check if the authenticated user is the one who created the reply or an admin
        if (auth()->user()->id === $reply->user_id || auth()->user()->isAdmin()) {
            $reply->delete();
            return response()->json(['message' => 'Reply deleted successfully.']);
        }
    
        return response()->json(['message' => 'Unauthorized.'], 403);
    }
    
}
