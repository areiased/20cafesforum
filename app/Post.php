<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = [
        'post_title', 'post_content', 'post_author','post_trimmed_desc',
    ];


    public function comments() {
        return $this->hasMany(Comment::class, 'original_post', 'id');
    }

    public function users() {
        return $this->belongsTo(User::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }
}
