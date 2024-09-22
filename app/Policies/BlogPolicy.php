<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\User;

class BlogPolicy
{
    /**
     * Create a new policy instance.
     */
    public function edit_delete_blog (User $user, Blog $blog) {
        return $user->id === $blog->user_id;
    }
}
