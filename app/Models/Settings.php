<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'sa_settings';

    protected $fillable = [
        'setting_name',
        'setting_key',
        'setting_value',
        'setting_description'
    ];
}
