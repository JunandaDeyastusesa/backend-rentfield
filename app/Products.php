<?php

namespace App;
use App\Category;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = "products";
    protected $primaryKey = "id";
    protected $fillable = ["name","available_quantity","price","description", "image", "id_kategori"];

    public function category()
    {
      return $this->belongsTo("App\Category","id_kategori");
    }
}
