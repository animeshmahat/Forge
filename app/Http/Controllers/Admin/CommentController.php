<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comments;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'message' => 'required|string',
        ]);

        // Create and save the comment
        Comments::create([
            'post_id' => $request->post_id,
            'parent_id' => $request->parent_id,
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        // Redirect back to the post view with a success message
        return redirect()->back()->with('success', 'Comment successfully added.');
    }
}
