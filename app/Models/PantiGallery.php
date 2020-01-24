<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PantiGallery extends Model
{
    protected $table = 'sa_panti_gallery';

    protected $fillable = [
        'panti_id',
        'gallery_filename',
        'gallery_fullname',
        'gallery_filesize',
        'is_thumb'
    ];

    public function panti()
    {
        return $this->belongsTo('App\Models\Panti', 'panti_id');
    }
}
