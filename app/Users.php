<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = "users";
    protected $primaryKey = "id";
    protected $fillable = ["id","name","email","password","role","image"];

    public function profil()
    {
      return $this->hasOne("App\Profil","id");
    }
    public function address()
    {
      return $this->hasMany("App\Address","id");
    }
}
