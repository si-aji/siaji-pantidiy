<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PantiContact extends Model
{
    protected $table = 'sa_panti_contact';

    protected $fillable = [
        'panti_id',
        'contact_type',
        'contact_value'
    ];

    public function panti()
    {
        return $this->belongsTo('App\Models\Panti', 'panti_id');
    }
}
