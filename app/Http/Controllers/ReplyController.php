<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reply;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ReplyController extends Controller
{
    public function store(Request $request)
    {
        dd($request->all());
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
    
        return response()->json(['message' => 'Reply created successfully.', 'reply' => $reply]);
    }



public function destroy($id)
{
    try {
        $reply = Reply::findOrFail($id);
        $reply->delete();
        return response()->json(['message' => 'Reply deleted successfully.'], 200);
    } catch (ModelNotFoundException $e) {
        return response()->json(['message' => 'Reply not found.'], 404);
    }
}


    

}
