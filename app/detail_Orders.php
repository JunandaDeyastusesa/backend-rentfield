<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detail_Orders extends Model
{
    protected $table = "detail_orders";
    protected $fillable = ["id_order", "id_product", "quantity"];

    public function order()
    {
      return $this->belongsTo("App\Orders", "id_order" ,"id");
    }

    public function product()
    {
      return $this->belongsTo("App\Products", "id_product","id");
    }
}
