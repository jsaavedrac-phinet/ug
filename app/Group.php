<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name','branch','fee'];

    public function users(){
        return $this->hasMany('App\User');
    }
}
