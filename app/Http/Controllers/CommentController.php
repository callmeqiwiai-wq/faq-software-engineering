<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        // Constructor
    }

    public function store(Request $request, Article $article)
    {
        $validated = $request->validate([
            'content' => 'required|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $comment = $article->comments()->create([
            'content' => $validated['content'],
            'user_id' => Auth::id(),
            'parent_id' => $validated['parent_id'] ?? null
        ]);

        if ($request->ajax()) {
            return response()->json([
                'comment' => $comment->load('user')
            ]);
        }

        return back()->with('status', 'Комментарий добавлен');
    }

    public function update(Request $request, Comment $comment)
    {
        // Allow the comment owner or admins/moderators to update the comment.
        $user = Auth::user();
        if ($user->id !== $comment->user_id && !($user->isAdmin() || $user->isModerator())) {
            abort(403, 'This action is unauthorized.');
        }

        $validated = $request->validate([
            'content' => 'required|max:1000'
        ]);

        $comment->update($validated);

        if ($request->ajax()) {
            return response()->json(['comment' => $comment]);
        }

        return back()->with('status', 'Комментарий обновлен');
    }

    public function destroy(Comment $comment)
    {
        // Allow the comment owner or admins/moderators to delete the comment.
        $user = Auth::user();
        if ($user->id !== $comment->user_id && !($user->isAdmin() || $user->isModerator())) {
            abort(403, 'This action is unauthorized.');
        }

        $comment->delete();

        if (request()->ajax()) {
            return response()->json(['status' => 'success']);
        }

        return back()->with('status', 'Комментарий удален');
    }
}
