<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Place;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created comment.
     */
    public function store(Request $request, Place $place)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        $comment = $place->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
            'rating' => $validated['rating'] ?? null,
            'is_approved' => false, // Comments need admin approval
        ]);

        return redirect()->back()->with('success', 'Your comment has been submitted and is awaiting approval.');
    }
}
