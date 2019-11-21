<?php

namespace App\Http\Controllers;

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
    	$userCollection = UserResource::collection($users);
    	return response($userCollection);
    }

    public function storeApi(User $user){
    	$this->authorize("index",User::class);
    	request()->validate(["name"=>"required","email"=>"required|email|unique:users","password"=>"required"]);
    	$user->create(["name"=>request("name"),"email"=>request("email"),"password"=>bcrypt(request("password"))]);
    }

    public function updateApi(User $user,$id){

    	$this->authorize("index",User::class);

    	request()->validate(
            [
                "name"=>"required",
                "email"=>["email","required"],
                "password"=>["required","sometimes"],
                "current_password"=>["required","sometimes",new MatchOldPassword],
                "confirmation_password"=>["same:password","sometimes","required"],
            ]
        );

        $data["name"] = request("name");
        if(request("password")) $data["password"] = bcrypt(request("password"));
        $data["email"] = request("email");

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
