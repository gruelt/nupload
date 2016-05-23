<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formulaire extends Model
{
    protected $fillable = ['name'];

    #retourne les users qui utilisent ce formulaire
    public function user()
    {
      return $this->belongsToMany('App\User');
    }


}
