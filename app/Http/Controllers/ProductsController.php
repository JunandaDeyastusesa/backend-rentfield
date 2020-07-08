<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Products;
use App\Category;
use Auth;
class ProductsController extends Controller
{

  function __construct()
  {

  }

  public function get()
  {
    $products = [];
    foreach (Products::all() as $p) {
      $item = [
        "name" => $p->name,
        "available_quantity" => $p->available_quantity,
        "price" => $p->price,
        "description" => $p->description,
        "image" => $p->image,
        "category" => $p->category->name,
      ];
      array_push($products,$item);
    }
    return response(["products" => $products]);
  }

  public function find(Request $request)
  {
    $find = $request->find;
    $products = [];
    foreach (Products::where("id","like","%$find%")->orWhere("name","like","%$find%")->orWhere("description","like","%$find%")->get() as $p) {
      $item = [
        "name" => $p->name,
        "available_quantity" => $p->available_quantity,
        "price" => $p->price,
        "description" => $p->description,
        "image" => $p->image,
        "category" => $p->category->name,
      ];
      array_push($products,$item);
    }
    return response(["products" => $products]);
  }

  public function save(Request $request)
  {
    $action = $request->action;
    if ($action == "insert") {
      try {

        $products = new Products();
        $products->name = $request->name;
        $products->available_quantity = $request->available_quantity;
        $products->price = $request->price;
        $products->description = $request->description;
        
        if($request->file('image')){
          $file = $request->file('image');
          $name = $file->getClientOriginalName();
          $file->move(\base_path() ."/public/images", $name);
          $products->image = $name;
        }

        $products->id_kategori = $request->id_kategori;

        $products->save();
      
        return response(["message" => "Data Produk berhasil ditambahkan"]);
      } catch (\Exception $e) {
        return response(["message" => $e->getMessage()]);
      }
    }else if($action == "update"){
      try {
        
        $products = Products::where("id", $request->id)->first();
        $products->name = $request->name;
        $products->available_quantity = $request->available_quantity;
        $products->price = $request->price;
        $products->description = $request->description;

        if($request->file('image')){
          $file = $request->file('image');
          $name = $file->getClientOriginalName();
          $file->move(\base_path() ."/public/images", $name);
          $products->image = $name;
        }

        $products->id_kategori = $request->id_kategori;

        $products->save();

        return response(["message" => "Data Produk berhasil diubah"]);
      } catch (\Exception $e) {
        return response(["message" => $e->getMessage()]);
      }
    }
  }

  public function drop($id)
  {
    try {
      Products::where("id", $id)->delete();
      return response(["message" => "Data Produk berhasil dihapus"]);
    } catch (\Exception $e) {
      return response(["message" => $e->getMessage()]);
    }
  }

}
 ?>
