<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'id', 'comment_content', 'username', 'original_post', 'comment_author', 'content'
    ];

    public function posts() {
        return $this->belongsTo(Post::class, 'id', 'original_post');
    }

    public function users() {
        return $this->belongsTo(User::class, 'id', 'comment_author');
    }
}
