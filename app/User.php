<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password', 'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function pantiLiputanAuthor()
    {
        return $this->hasMany('App\Models\PantiLiputan', 'author_id');
    }
    public function pantiLiputanEditor()
    {
        return $this->hasMany('App\Models\PantiLiputan', 'editor_id');
    }
    public function postAuthor()
    {
        return $this->hasMany('App\Models\Post', 'author_id');
    }
    public function postEditor()
    {
        return $this->hasMany('App\Models\Post', 'editor_id');
    }
}
