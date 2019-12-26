<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Rules\MatchOldPassword;
use App\User;
use Carbon\Carbon;

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

    public function filter($model)
    {
        if( request("userName") != "" ) 
        $model = $model->where( "name","like","%".request("userName")."%" );
        if(request("userEmail")!="") $model=$model->where("email",request("userEmail"));
        if(request("userCreated")!="") $model=$model->whereBetween("created_at",[
            Carbon::parse(request("userCreated"))->startOfDay(),
            Carbon::parse(request("userCreated"))->endOfDay()
        ]);
        if(request("userGroupId") != "") $model=$model->where("group_id",request("userGroupId"));


        return $model
        ->orderBy(request("sortBy"),request("sortType"))
        ->paginate(request("limit"));
    }


    public function indexApi(User $user){
    	$this->authorize("index",User::class);
    	$users = $this->filter($user->where('superAdmin',0));
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
