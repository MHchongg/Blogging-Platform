<?php

namespace App\Models;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tag(string $name) {
        $tag = Tag::firstOrCreate(['name' => $name]);

        $this->tags()->attach($tag);
    }

    public function user () {
        return $this->belongsTo(User::class);
    }

    public function comments () {
        return $this->hasMany(Comment::class);
    }

    public function tags () {
        return $this->belongsToMany(Tag::class);
    }

    public function likes () {
        return $this->morphMany(Like::class, 'likable');
    }
}
