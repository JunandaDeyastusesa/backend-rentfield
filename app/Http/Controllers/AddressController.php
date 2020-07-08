<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Address;
use Auth;
class AddressController extends Controller
{

  function __construct()
  {

  }

  public function get($id_user)
  {
    $address = Address::find($id_user);
    return response([
      "address" => $address
    ]);
  }

  public function save(Request $request)
  {
    $action = $request->action;
    if ($action == "insert") {
      try {
        $address = new Address();
        $address->street = $request->street;
        $address->rt = $request->rt;
        $address->rw = $request->rw;
        $address->district = $request->district;
        $address->city = $request->city;
        $address->zip_code = $request->zip_code;
        $address->id_user = $request->id_user;
        $address->save();
        
        return response(["message" => "Data alamat berhasil ditambahkan"]);
      } catch (\Exception $e) {
        return response(["message" => $e->getMessage()]);
      }
    }else if($action == "update"){
      try {
        $address = address::where("id", $request->id)->first();
        $address->street = $request->street;
        $address->rt = $request->rt;
        $address->rw = $request->rw;
        $address->district = $request->district;
        $address->city = $request->city;
        $address->zip_code = $request->zip_code;
        $address->save();

        return response(["message" => "Data alamat berhasil diubah"]);
      } catch (\Exception $e) {
        return response(["message" => $e->getMessage()]);
      }
    }
  }

  public function drop($id)
  {
    try {
      Address::where("id", $id)->delete();
      return response(["message" => "Data alamat berhasil dihapus"]);
    } catch (\Exception $e) {
      return response(["message" => $e->getMessage()]);
    }
  }
}
 ?>
