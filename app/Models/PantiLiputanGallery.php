<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PantiLiputanGallery extends Model
{
    protected $table = 'sa_panti_liputan_gallery';

    protected $fillable = [
        'liputan_id',
        'gallery_filename',
        'gallery_fullname',
        'gallery_filesize',
    ];

    public function pantiLiputan()
    {
        return $this->belongsTo('App\Models\PantiLiputan', 'liputan_id');
    }
}
