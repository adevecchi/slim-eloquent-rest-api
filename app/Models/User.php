<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = ['name', 'email', 'password'];

    public $timestamps = false;

    public function contacts()
    {
        return $this->hasMany('App\Models\Contact', 'users_id', 'id');
    }
}
