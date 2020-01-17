<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panti extends Model
{
    protected $table = 'sa_panti';

    protected $fillable = [
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'panti_name',
        'panti_slug',
        'panti_alamat',
        'panti_description'
    ];

    public function provinsi()
    {
        return $this->belongsTo('App\Models\Provinsi', 'provinsi_id');
    }
    public function kabupaten()
    {
        return $this->belongsTo('App\Models\Kabupaten', 'kabupaten_id');
    }
    public function kecamatan()
    {
        return $this->belongsTo('App\Models\Kecamatan', 'kecamatan_id');
    }

    public function pantiLiputan()
    {
        return $this->hasMany('App\Models\PantiLiputan', 'panti_id');
    }
    public function pantiContact()
    {
        return $this->hasMany('App\Models\PantiContact', 'panti_id');
    }
    public function donation()
    {
        return $this->hasMany('App\Models\Donation', 'panti_id');
    }
}
