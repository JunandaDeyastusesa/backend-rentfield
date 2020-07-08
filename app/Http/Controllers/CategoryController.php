<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Products;
use App\Category;
use Auth;
class CategoryController extends Controller
{

  function __construct()
  {

  }

  public function get()
  {
    return response (["category" => Category::all()]);
  }

  public function find(Request $request)
  {
    $find = $request->find;
    $category = [];
    foreach (Category::where("id","like","%$find%")->orWhere("name","like","%$find%")->get() as $c) {
      $item = [
        "name" => $c->name,
      ];
      array_push($category,$item);
    }
    return response(["category" => $category]);
  }

  public function save(Request $request)
  {
    $action = $request->action;
    if ($action == "insert") {
      try {

        $category = new Category();
        $category->name = $request->name;

        $category->save();
      
        return response(["message" => "Data Kategori berhasil ditambahkan"]);
      } catch (\Exception $e) {
        return response(["message" => $e->getMessage()]);
      }
    }else if($action == "update"){
      try {
        
        $category = Category::where("id", $request->id)->first();
        $category->name = $request->name;

        $category->save();

        return response(["message" => "Data Kategori berhasil diubah"]);
      } catch (\Exception $e) {
        return response(["message" => $e->getMessage()]);
      }
    }
  }

  public function drop($id)
  {
    try {
      Category::where("id", $id)->delete();
      return response(["message" => "Data Kategori berhasil dihapus"]);
    } catch (\Exception $e) {
      return response(["message" => $e->getMessage()]);
    }
  }
}
 ?>
