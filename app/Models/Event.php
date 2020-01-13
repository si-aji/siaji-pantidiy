<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'sa_event';

    protected $fillable = [
        'event_title',
        'event_slug',
        'event_thumbnail',
        'event_description',
        'event_start',
        'event_end',
        'event_place'
    ];
}
