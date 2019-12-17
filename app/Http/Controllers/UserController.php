<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Rules\MatchOldPassword;
use App\User;

class UserController extends Controller
{

	public function __construct(){
		$this->middleware("authMiddleware");
	}

    public function index(){
    	$this->authorize("index",User::class);
    	return view('users.index');
    }

    public function edit(){
        return view("users.edit");
    }


    public function indexApi(User $user){
    	$this->authorize("index",User::class);
    	$users = $user->where('superAdmin',0)->where("name","like","%".request("filter")."%")->paginate(10);
    	$userCollection = new UserCollection($users);
    	return response($userCollection);
    }

    public function storeApi(User $user){
    	$this->authorize("index",User::class);
    	request()->validate(["name"=>"required","email"=>"required|email|unique:users","password"=>"required","group_id"=>"required"]);
    	$user->create(["name"=>request("name"),"email"=>request("email"),"password"=>bcrypt(request("password")),"group_id"=>request("group_id")]);
    }

    public function updateApi(User $user,$id){

    	$this->authorize("edit",User::class);

    	request()->validate(
            [
                "name"=>"required",
                "email"=>["email","required"],
                "password"=>["required","sometimes"],
                "current_password"=>["required","sometimes",new MatchOldPassword],
                "confirmation_password"=>["same:password","sometimes","required"],
                "group_id"=>["required","sometimes"],
            ]
        );

        $data["name"] = request("name");
        if(request("password")) $data["password"] = bcrypt(request("password"));
        $data["email"] = request("email");
        $data["group_id"] = request("group_id");

    	$user->find($id)->update($data);
    }

    public function deleteApi(User $user,$id){
    	$this->authorize("index",User::class);
    	$user->find($id)->delete();
    }

    public function editApi(User $user,$id){
        $user = $user->find($id);
        return new UserResource($user);
    }
}
