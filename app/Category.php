<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  //restricts columns from modifying
    protected $guarded = [];

    protected $fillable = ['id','category_title', 'category_active', 'posts_ids', 'categories_ids'];

  // the forum has a lot of categories
  // returns all categories on the forum currently (table "categories")
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}