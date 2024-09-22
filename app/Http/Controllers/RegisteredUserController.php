<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    public function create () {
        return view('auth.register');
    }

    public function store (Request $request) {
        $validatedAttr = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:6']
        ]);

        $user = User::create($validatedAttr);

        Auth::login($user);

        return redirect('/');
    }

    public function profile () {
        $myBlogs = Blog::where('user_id', Auth::id())->simplePaginate(5);

        $likedBlogs_id = Like::where('user_id', Auth::id())->where('likable_type', 'App\Models\Blog')->pluck('likable_id')->toArray();
        $likedBlogs = Blog::whereIn('id', $likedBlogs_id)->simplePaginate(5);

        return view('profile', ['myBlogs' => $myBlogs, 'likedBlogs' => $likedBlogs]);
    }
}
