<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    protected $table = 'sa_keyword';

    protected $fillable = [
        'keyword_title',
        'keyword_slug',
    ];
}
