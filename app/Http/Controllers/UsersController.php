<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Users;
use App\Profil;
use Auth;
class UsersController extends Controller
{

  function __construct()
  {

  }

  public function get()
  {
    $users = [];
    foreach (Profil::all() as $u) {
      $item = [
        "id" => $u->user->id,
        "username" => $u->user->username,
        "email" => $u->user->email,
        "password" => Crypt::decrypt($u->user->password),
        "role" => $u->user->role,
        "first_name" => $u->first_name,
        "last_name" => $u->last_name,
        "gender" => $u->gender,
        "date_birth" => $u->date_birth,
        "image" => $u->image,
      ];
      array_push($users, $item);
    }
    return response([
      "users" => $users
    ]);
  }

  public function getUser($id)
  {
    $users = Profil::find($id)->user;
    $profil = Profil::find($id);
    return response([
      "users" => $users, "profil" => $profil
    ]);
    
  }

  public function getProfil($id)
  {
    $users = Profil::find($id);
    return response([
      "users" => $users
    ]);
    
  }

  public function find(Request $request)
  {
    $find = $request->find;
    $users = [];
    foreach (Profil::where("first_name","like","%$find%")->orWhere("last_name","like","%$find%")->get() as $u) {
      $item = [
        "id" => $u->user->id,
        "username" => $u->user->username,
        "email" => $u->user->email,
        "password" => Crypt::decrypt($u->user->password),
        "role" => $u->user->role,
        "first_name" => $u->first_name,
        "last_name" => $u->last_name,
        "gender" => $u->gender,
        "date_birth" => $u->date_birth,
        "image" => $u->image,
      ];
      array_push($users, $item);
    }
    return response([
      "users" => $users
    ]);
  }

  public function save(Request $request)
  {
    $action = $request->action;
    if ($action == "insert") {
      try {
        $users = new Users();
        $users->username = $request->username;
        $users->email = $request->email;
        $users->password = Crypt::encrypt($request->password);
        $users->role = $request->role;
        $users->save();

        $u = Users::where("email", $request->email)->first();
        $profil = new Profil();
        $profil->id_user = $u->id;
        $profil->first_name = $request->first_name;
        $profil->last_name = $request->last_name;
        $profil->gender = $request->gender;
        $profil->date_birth = $request->date_birth;
        
        if($request->file('image')){
          $file = $request->file('image');
          $name = $file->getClientOriginalName();
          $file->move(\base_path() ."/public/images", $name);
          $profil->image = $name;
        }
        $profil->save();
        
        return response(["message" => "Data user berhasil ditambahkan"]);
      } catch (\Exception $e) {
        return response(["message" => $e->getMessage()]);
      }
    }else if($action == "update"){
      try {
        $users = Users::where("id", $request->id)->first();
        $users->username = $request->username;
        $users->email = $request->email;
        $users->password = Crypt::encrypt($request->password);
        $users->role = $request->role;
        $users->save();

        $profil = Profil::where("id_user", $request->id)->first();
        $profil->first_name = $request->first_name;
        $profil->last_name = $request->last_name;
        $profil->gender = $request->gender;
        $profil->date_birth = $request->date_birth;
        
        if($request->file('image')){
          $file = $request->file('image');
          $name = $file->getClientOriginalName();
          $file->move(\base_path() ."/public/images", $name);
          $profil->image = $name;
        }
        $profil->save();
        return response(["message" => "Data user berhasil diubah"]);
      } catch (\Exception $e) {
        return response(["message" => $e->getMessage()]);
      }
    }
  }

  public function Profil(Request $request)
  {
      try {
        $profil = Profil::where("id_user", $request->id_user)->first();
        $profil->first_name = $request->first_name;
        $profil->last_name = $request->last_name;
        $profil->gender = $request->gender;
        $profil->date_birth = $request->date_birth;
        if($request->file('image')){
          $file = $request->file('image');
          $name = $file->getClientOriginalName();
          $file->move(\base_path() ."/public/images", $name);
          $profil->image = $name;
        }
        else{
          $profil->image = "Avatar.png";
        }
        $profil->save();
        return response(["message" => "Data profil berhasil diubah"]);
      } catch (\Exception $e) {
        return response(["message" => $e->getMessage()]);
      }
  }

  public function drop($id)
  {
    try {
      Users::where("id", $id)->delete();
      return response(["message" => "Data user berhasil dihapus"]);
    } catch (\Exception $e) {
      return response(["message" => $e->getMessage()]);
    }
  }

  public function register(Request $request)
  {
    try {
        $users = new Users();
        $users->username = $request->username;
        $users->email = $request->email;
        $users->password = Crypt::encrypt($request->password);
        $users->role = "user";
        $users->save();

        $u = Users::where("email", $request->email)->first();
        $profil = new Profil();
        $profil->id_user = $u->id;
        $profil->save();
        
        return response(["message" => "Register berhasil"]);
    } catch (\Exception $e) {
        return response(["message" => $e->getMessage()]);
    }
  }

  public function login(Request $request)
  {
    $username = $request->username;
    $password = $request->password;    

    $users = Users::where("username", $username)->orwhere("email", $username);
    if ($users->count() > 0) {
      // login sukses
      $u = $users->first();
      if(Crypt::decrypt($u->password) == $password){
        return response(["status" => true, "users" => $u, "token" => Crypt::encrypt($u->id)]);
      }else{
        return response(["status" => false]);
      }
    }else{
      return response(["status" => false]);
    }
  }
}
 ?>
