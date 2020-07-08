<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = "address";
    protected $primaryKey = "id";
    protected $fillable = ["street","rt","rw","district","city","zip_code","id_user"];

    public function user()
    {
      return $this->belongsTo("App\Users","id_user", "id");
    }
}
