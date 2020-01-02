<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'sa_post';

    protected $fillable = [
        'category_id',
        'author_id',
        'editor_id',
        'post_title',
        'post_slug',
        'post_thumbnail',
        'post_content',
        'post_shareable',
        'post_commentable',
        'post_status',
        'post_published'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }
    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }
    public function editor()
    {
        return $this->belongsTo('App\User', 'editor_id');
    }
}
