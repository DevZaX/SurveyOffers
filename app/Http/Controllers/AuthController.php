<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function edit(){
    	return view("auth/edit");
    }

    public function create(){
    	request()->validate(["email"=>"required|email","password"=>"required"]);
    	if( \Auth::attempt(["email"=>request("email"),"password"=>request("password")]) ){}
        else return response(["message"=>"These credentials do not match our records."],500);
    }

    public function show(){
    	$user = auth()->user();
    	return new UserResource($user);
    }

    public function destory(){
    	\Auth::logout();
    	return back();
    }
}
