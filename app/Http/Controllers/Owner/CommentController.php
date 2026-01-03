<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Reply to a comment (only if you own the place).
     */
    public function reply(Request $request, Comment $comment)
    {
        $user = auth()->user();

        // Check if user owns the place this comment is on
        if ($comment->place->owner_id !== $user->id) {
            abort(403, 'You can only reply to comments on your own places.');
        }

        // Check if comment is approved (optional - owners might want to reply to pending ones too)
        if (!$comment->is_approved) {
            return redirect()->back()->with('error', 'You can only reply to approved comments.');
        }

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $reply = Comment::create([
            'place_id' => $comment->place_id,
            'user_id' => $user->id,
            'parent_id' => $comment->id,
            'content' => $validated['content'],
            'is_approved' => true, // Owner replies are auto-approved
        ]);

        return redirect()->back()->with('success', 'Your reply has been posted.');
    }
}
