<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PantiLiputan extends Model
{
    protected $table = 'sa_panti_liputan';

    protected $fillable = [
        'panti_id',
        'author_id',
        'editor_id',
        'liputan_date',
        'liputan_thumbnail',
        'liputan_content'
    ];

    public function panti()
    {
        return $this->belongsTo('App\Models\Panti', 'panti_id');
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }
    public function editor()
    {
        return $this->belongsTo('App\User', 'editor_id');
    }

    public function pantiLiputanGallery()
    {
        return $this->hasMany('App\Models\PantiLiputanGallery', 'liputan_id');
    }
}
