<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Orders;
use App\detail_Orders;
use App\Users;
use App\Profil;
use App\Address;
use App\Products;
use App\Category;
use Auth;
class OrdersController extends Controller
{

  function __construct()
  {

  }

  public function get()
  {
    $order = [];
    foreach (Orders::all() as $o) {
      $detail = [];
      foreach ($o->detail_order as $d) {
        $itemDetail = [
          "id_order" => $d->id_order,
          "id_product" => $d->id_product,
          "nama_product" => $d->product->name,
          "quantity" => $d->quantity
        ];
        array_push($detail, $itemDetail);
      }
      $item = [
        "id_order" => $o->id,
        "id_user" => $o->id_user,
        "nama_user" => $o->user->username,
        "id_address" => $o->id_address,
        "street" => $o->address->street,
        "total" => $o->total,
        "bukti_bayar" => $o->bukti_bayar,
        "status" => $o->status,
        "detail" => $detail
      ];
       array_push($order,$item);
    }
    return response(["orders" => $order]);
  }

  public function getById($id_user)
  {
    $order = [];
    foreach (Orders::where("id_user", $id_user)->get() as $o) {
      $detail = [];
      foreach ($o->detail_order as $d) {
        $itemDetail = [
          "id_order" => $d->id_order,
          "id_product" => $d->id_product,
          "nama_product" => $d->product->name,
          "quantity" => $d->quantity
        ];
        array_push($detail, $itemDetail);
      }
      $item = [
        "id_order" => $o->id,
        "id_user" => $o->id_user,
        "nama_user" => $o->user->name,
        "id_address" => $o->id_address,
        "total" => $o->total,
        "bukti_bayar" => $o->bukti_bayar,
        "status" => $o->status,
        "detail" => $detail
      ];
       array_push($order,$item);
    }
    return response(["order" => $order]);
  }

  public function save(Request $request)
  {
      try {
        $orders = new Orders();
        $orders->id_user = $request->id_user;
        $orders->id_address = $request->id_address;
        $orders->total = $request->total;
        $orders->status = "dipesan";
        $orders->save();
        
        $o = Orders::where("id_user", $request->id_user)->latest()->first();
        // foreach($request->id_product)
        // {
        $detail_orders = new detail_Orders();
        $detail_orders->id_order = $o->id;
        $detail_orders->id_product = $request->id_product;
        $detail_orders->quantity = $request->quantity;
        $detail_orders->save();
        // }
           
        return response(["message" => "Data Orders berhasil ditambahkan"]);
      } catch (\Exception $e) {
        return response(["message" => $e->getMessage()]);
      }
  }

  public function accept($id)
  {
    $o = Orders::where("id", $id)->first();
    $o->status = "dikirim";
    $o->save();
  }

  public function decline($id) 
  {
    $o = Orders::where("id", $id)->first();
    $o->status = "dibatalkan";
    $o->save();
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
