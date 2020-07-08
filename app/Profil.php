<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    protected $table = "profil";
    protected $primaryKey = "id_user";
    protected $fillable = ["first_name","last_name","gender","date_birth"];

    public function user()
    {
      return $this->belongsTo("App\Users","id_user", "id");
    }
}
