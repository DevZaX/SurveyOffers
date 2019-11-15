<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\User;

class UserController extends Controller
{

	public function __construct(){
		//$this->middleware("auth");
	}

    public function index(){
    	//$this->authorize("index",User::class);
    	return view('users.index');
    }


    public function indexApi(User $user){
    	//$this->authorize("index",User::class);
    	$users = $user->where('superAdmin',0)->paginate(10);
    	$userCollection = UserResource::collection($users);
    	return response($userCollection);
    }

    public function storeApi(User $user){
    	//$this->authorize("index",User::class);
    	request()->validate(["name"=>"required","email"=>"required|email","password"=>"required"]);
    	$user->create(["name"=>request("name"),"email"=>request("email"),"password"=>bcrypt(request("password"))]);
    }

    public function updateApi(User $user,$id){
    	//$this->authorize("index",User::class);
    	request()->validate(["name"=>"required","email"=>"required|email","password"=>"required|sometimes"]);
    	$user->find($id)->update(["name"=>request("name"),"email"=>request("email"),"password"=>bcrypt(request("password"))]);
    }

    public function deleteApi(User $user,$id){
    	//$this->authorize("index",User::class);
    	$user->find($id)->delete();
    }
}
