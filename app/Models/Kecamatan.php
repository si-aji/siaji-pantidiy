<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'sa_lkecamatan';

    protected $fillable = [
        'kabupaten_id',
        'kecamatan_name'
    ];

    public function kabupaten()
    {
        return $this->belongsTo('App\Models\Kabupaten', 'kabupaten_id');
    }
}
