<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $table = 'sa_donation';

    protected $fillable = [
        'panti_id',
        'donation_title',
        'donation_description',
        'donation_start',
        'donation_end',
        'donation_hasdeadline',
        'donation_needed'
    ];

    public function panti()
    {
        return $this->belongsTo('App\Models\Panti', 'panti_id');
    }

    public function scopeGetDonation()
    {
        return $this->orderBy('created_at', 'asc');
    }
}
