<?php

namespace App\Models;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function blogs(){
        return $this->belongsToMany(Blog::class,'category_blogs','category_id','blog_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'created_by','id');
    }
}
