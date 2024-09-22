<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\Tag;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index () {
        $blogs = Blog::latest()->simplePaginate(5);

        return view('blogs.index', ['blogs' => $blogs]);
    }

    public function create () {
        return view('blogs.create');
    }

    public function store (Request $request) {

        $validatedAttr = $request->validate([
            'title' => ['required', 'max:20'],
            'content' => ['required', 'min:5'],
            'tags' => ['nullable'],
            'image' => ['nullable', 'image']
        ]);

        $validatedAttr['user_id'] = Auth::id();

        $blog = Blog::create(Arr::except($validatedAttr, 'tags'));

        if ($validatedAttr['tags'] ?? false) {
            $strip_tags = str_replace(' ', '', $validatedAttr['tags']);
            foreach (explode(',', $strip_tags) as $tag) {
                $blog->tag($tag);
            }
        }

        if ($request->hasFile('image')) {
            // For the first time, run command php artisan storage:link to create symbolic link
            $imagePath = $request->image->store('images/' . $blog->id);
            $blog->update(['image' => 'storage/' . $imagePath]);
        }

        return redirect('/')->with([
            'type' => 'success',
            'message' => 'New blog is created successfully'
        ]);
    }

    public function show (Blog $blog) {
        $comments = Comment::where('blog_id', $blog->id)->withCount('likes')->orderBy('likes_count', 'desc')->simplePaginate(5);

        return view('blogs.show', ['blog' => $blog, 'comments' => $comments]);
    }

    public function edit (Blog $blog) {
        return view('blogs.edit', ['blog' => $blog]);
    }

    public function update(Request $request, Blog $blog) {
        $validatedAttr = $request->validate([
            'title' => ['required', 'max:20'],
            'content' => ['required', 'min:5'],
            'tags' => ['nullable'],
            'image' => ['nullable', 'image']
        ]);

        if ($request->hasFile('image')) {

            Storage::deleteDirectory('images/' . $blog->id);

            $imagePath = $request->image->store('images/' . $blog->id);
            $validatedAttr['image'] = 'storage/' . $imagePath;
        }

        $blog->update(Arr::except($validatedAttr, 'tags'));

        if ($validatedAttr['tags'] ?? false) {
            $strip_tags = str_replace(' ', '', $validatedAttr['tags']);
            foreach (explode(',', $strip_tags) as $tag) {
                $new_tag = Tag::firstOrCreate(['name' => $tag]);
                $tag_id[] = $new_tag->id;
            }
            $blog->tags()->sync($tag_id);
        }

        return redirect('/show/' . $blog->id)->with([
            'type' => 'success',
            'message' => 'Blog is updated successfully'
        ]);
    }

    public function destroy (Blog $blog) {

        foreach ($blog->comments as $comment) {
            $comment->likes()->delete();
        }

        $blog->likes()->delete();
        $blog->delete();

        Storage::deleteDirectory('images/' . $blog->id);

        return redirect('/')->with([
            'type' => 'success',
            'message' => 'Blog is deleted successfully'
        ]);
    }

    public function sort (Request $request) {
        $sortOption = $request->input('blog-sort');

        if ($sortOption === 'Hottest') {
            $blogs = Blog::withCount('likes')->orderBy('likes_count', 'desc')->simplePaginate(5);
        }
        else {
            $blogs = Blog::latest()->simplePaginate(5);
        }

        return view('blogs.index', ['blogs' => $blogs, 'selectedSortOption' => $sortOption]);
    }

    public function search () {
        $blogs = Blog::whereAny(['title', 'content'], 'LIKE', '%'.request('query').'%')
        ->orWhereHas('tags', function ($query) {
            $query->where('name', 'LIKE', '%'.request('query').'%');
        })
        ->simplePaginate(5);

        return view('results', ['blogs' => $blogs, 'query' => request('query')]);
    }

    public function toggleBlogLike (Blog $blog) {
        // Check if the user has already liked the blog
        if (!$blog->likes()->where('user_id', Auth::id())->exists()) {
            $blog->likes()->create(['user_id' => Auth::id()]);
            $status = true;
        } else {
            $blog->likes()->where('user_id', Auth::id())->delete();
            $status = false;
        }

        return response()->json([
            'status' => $status,
            'blog_likes_count' => $blog->likes()->count(),
        ]);
    }
}
