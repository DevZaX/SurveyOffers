<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
     public function __construct()
    {
    	$this->middleware("authMiddleware");
    }

    public function index()
    {
    	$this->authorize("index",Category::class);
    	return view("categories.index");
    }

    public function indexApi(Category $category)
    {
    	$this->authorize("index",Category::class);
    	$categories = $category->where("name","like",request("filter")."%")->paginate(10);
    	return new CategoryCollection($categories);
    }

    public function storeApi(Category $category)
    {
    	$this->authorize("store",Category::class);

    	request()->validate( [ "name"=>"required|unique:categories" ] );

    	$category->create( [ "name"=>request("name"),"status"=>1 ] );
    }

    public function updateApi(Category $category,$id)
    {
    	$this->authorize("update",Category::class);

    	request()->validate( [ "name"=>"required|sometimes","status"=>"required|sometimes" ] );

    	$category->find($id)->update( [ "name"=>request( "name" ),"status"=>request("status") ] );
    }

    public function destroyApi(Category $category,$id)
    {
    	$this->authorize("destroy",Category::class);

    	$category->find($id)->delete();
    }


    public function all(Category $category)
    {
        $categories = $category->all();
        return CategoryResource::collection($categories);
    }
}
