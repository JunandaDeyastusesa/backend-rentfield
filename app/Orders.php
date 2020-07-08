<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = "orders";
    protected $primaryKey = "id";
    protected $fillable = ["id_user", "id_address", "total", "bukti_bayar","status"];

    public function user()
    {
      return $this->belongsTo("App\Users", "id_user" ,"id");
    }
    public function address()
    {
      return $this->belongsTo("App\Address", "id_address","id");
    }
    public function detail_order()
    {
      return $this->hasMany("App\detail_Orders","id_order");
    }
}
