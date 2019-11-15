<?php

namespace App\Http\Controllers;

class ImageController extends Controller
{
    public function store(){
    	return request()->file("image")->store("images");
    }
}
