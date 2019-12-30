<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'sa_page';
    
    protected $fillable = [
        'page_title',
        'page_slug',
        'page_thumbnail',
        'page_content',
        'page_shareable',
        'page_status',
        'page_published'
    ];
}
