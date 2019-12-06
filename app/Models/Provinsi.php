<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = 'sa_lprovinsi';

    protected $fillable = [
        'provinsi_name'
    ];

    public function kabupaten()
    {
        return $this->hasMany('App\Models\Kabutapen', 'provinsi_id');
    }
}
