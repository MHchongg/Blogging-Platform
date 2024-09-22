<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::controller(BlogController::class)->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/create', 'create');
        Route::post('/store', 'store');
        Route::get('/edit/{blog}', 'edit')->can('edit_delete_blog', 'blog');
        Route::patch('/update/{blog}', 'update')->can('edit_delete_blog', 'blog');
        Route::delete('/blog/{blog}', 'destroy')->can('edit_delete_blog', 'blog');
        Route::post('/toggleBlogLike/{blog}', 'toggleBlogLike');
    });
    Route::get('/', 'index');
    Route::get('/show/{blog}', 'show');
    Route::get('/blog/sort', 'sort');
    Route::get('/search', 'search');
});

Route::controller(CommentController::class)->group(function () {
    Route::get('/comment/sort/{blog}', 'sort');
    Route::middleware('auth')->group(function () {
        Route::post('/comment/{blog}', 'store');
        Route::post('/toggleCommentLike/{comment}', 'toggleCommentLike');
    });
});

Route::controller(SessionController::class)->group(function () {
    Route::get('/login', 'create')->name('login');
    Route::post('/login', 'store');
    Route::post('/logout', 'destroy');
});

Route::controller(RegisteredUserController::class)->group(function () {
    Route::get('/register', 'create');
    Route::post('/register', 'store');
    Route::get('/profile', 'profile')->middleware('auth');
});