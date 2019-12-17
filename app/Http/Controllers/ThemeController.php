<?php

namespace App\Http\Controllers;

use App\Http\Resources\ThemeCollection;
use App\Http\Resources\ThemeResource;
use App\Theme;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function __construct()
    {
        $this->middleware("authMiddleware");
    }
    
     public function index()
    {
    	$this->authorize("index",Theme::class);
    	return view("themes.index");
    }

    public function indexApi(Theme $theme)
    {
    	$this->authorize("index",Theme::class);
    	$themes = $theme
    	->where("name","like","%".request("filter")."%")
    	->where("geo","like","%".request("geo")."%")
	->where("status","like","%".request("status")."%")
    	->paginate(10);
    	return new ThemeCollection($themes);
    }

    public function storeApi(Theme $theme)
    {
    	$this->authorize("store",Theme::class);

    	request()->validate( [ "name"=>"required|unique:themes","geo"=>"required","theme_preview"=>"required" ] );

    	$theme->create( [ "name"=>request("name"),"geo"=>request("geo"),"theme_preview"=>request("theme_preview") ] );
    }

    public function updateApi(Theme $theme,$id)
    {
    	$this->authorize("update",Theme::class);

    	request()->validate( 
    		[ 
    			"name"=>"required|sometimes",
	    		"geo"=>"required|sometimes" ,
	    		"status"=>"required|sometimes",
	    		"theme_preview"=>"required|sometimes",
	    	]
    		 );

    	$theme->find($id)->update(
    		[
    			"name"=>request( "name" ),
    			"geo"=>request("geo"),
    			"status"=>request("status"),
    			"theme_preview"=>request("theme_preview"),
    		]
    	);
    }

    public function destroyApi(Theme $theme,$id)
    {
    	$this->authorize("destroy",Theme::class);

    	$theme->find($id)->delete();
    }

    public function getThemes(Theme $theme,$geo)
    {
    	$themes = $theme->where("geo",$geo)->where("status",1)->get();
    	return ThemeResource::collection($themes);
    }

    public function getAllTheme(Theme $theme)
    {
    	$themes = $theme->where("status",1)->get();
    	return ThemeResource::collection($themes);
    }

}
