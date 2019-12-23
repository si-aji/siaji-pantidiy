<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PantiLiputan extends Model
{
    protected $table = 'sa_panti_liputan';

    protected $fillable = [
        'panti_id',
        'user_id',
        'liputan_date',
        'liputan_thumbnail',
        'liputan_content'
    ];

    public function panti()
    {
        return $this->belongsTo('App\Models\Panti', 'panti_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
