<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_blogs', 'blog_id', 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function allComments()
    {
        return $this->hasMany(Comment::class, 'item_id', 'id');
    }
    public function comments()
    {
        return $this->allComments()->with('user')->where('type', 'blogs')->latest();
    }
    public function lastComment()
    {
        return $this->allComments()->with('user')->where('type', 'blogs')->latest()->limit(1);
    }
}
