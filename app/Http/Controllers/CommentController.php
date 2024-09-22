<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store (Request $request, Blog $blog) {
        $validatedtAttr = $request->validate([
            'content' => ['required']
        ]);

        $validatedtAttr['user_id'] = Auth::id();
        $validatedtAttr['blog_id'] = $blog->id;

        Comment::create($validatedtAttr);

        return redirect('/show/' . $blog->id)->with([
            'type' => 'success',
            'message' => 'Comment successfully'
        ]);
    }

    public function sort (Request $request, Blog $blog) {
        $sortOption = $request->input('comment-sort');

        if ($sortOption === 'Hottest') {
            $comments = Comment::where('blog_id', $blog->id)->withCount('likes')->orderBy('likes_count', 'desc')->simplePaginate(5);
        }
        else {
            $comments = Comment::where('blog_id', $blog->id)->orderBy('created_at', 'desc')->simplePaginate(5);
        }

        return view('blogs.show', ['blog' => $blog, 'comments' => $comments, 'selectedSortOption' => $sortOption]);
    }

    public function toggleCommentLike (Comment $comment) {
        // Check if the user has already liked the comment
        if (!$comment->likes()->where('user_id', Auth::id())->exists()) {
            $comment->likes()->create(['user_id' => Auth::id()]);
            $status = true;
        } else {
            $comment->likes()->where('user_id', Auth::id())->delete();
            $status = false;
        }

        return response()->json([
            'status' => $status,
            'comment_likes_count' => $comment->likes()->count(),
        ]);
    }
}
