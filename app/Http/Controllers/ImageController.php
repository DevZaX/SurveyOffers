<?php

namespace App\Http\Controllers;

class ImageController extends Controller
{
    public function store(){
    	request()->validate(["image"=>"required|image|mimes:jpeg,png,jpg,gif,svg|max:2048"]);
    	return request()->file("image")->store("images");
    }
}
