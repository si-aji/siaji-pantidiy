<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'sa_category';

    protected $fillable = [
        'category_title',
        'category_slug',
        'category_description',
    ];
}
