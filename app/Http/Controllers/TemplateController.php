<?php

namespace App\Http\Controllers;

use App\Http\Resources\OfferResource;
use App\Http\Resources\TemplateCollection;
use App\Http\Resources\TemplateResource;
use App\Template;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware("authMiddleware");
    }

    public function index()
    {
    	$this->authorize("index",Template::class);
    	return view("templates.index");
    }

    public function filter($model)
    {
        if( request("templateName") != "" ) $model = $model->where("name","like","%".request("templateName")."%");
        if( request("templateGeo") != "" ) $model = $model->where("geo",request("templateGeo"));
        if( request("templateGroupId") != "" ) $model = $model->where("group_id",request("templateGroupId"));
        if( request("templateCreated") != "" ) $model = $model
        ->whereBetween("created_at",[
            Carbon::parse( request("templateCreated") )->startOfDay(),
            Carbon::parse( request("templateCreated") )->endOfDay(),
        ]);
        if( request("templateStatus") != null ) $model = $model->where("isActive",request("templateStatus"));

        return $model
        ->orderBy( request("sortBy"),request("sortType") )
        ->paginate(request("limit"));
    }

    public function indexApi(Template $template)
    {
    	$this->authorize("index",Template::class);
        if( auth()->user()->superAdmin ) $templates = $this->filter($template);
        else $templates = $this->filter(auth()->user()->group->templates());
    	return new TemplateCollection($templates);
    }

    public function storeApi(Template $template)
    {

    	$this->authorize("store",Template::class);

    	request()->validate( [ "name"=>"required|unique:templates","geo"=>"required","group_id"=>"required","theme_id"=>"required" ] );

    	$template->create( [ "name"=>request("name"),"geo"=>request("geo"),"group_id"=>request("group_id"),"theme_id"=>request("theme_id") ] );
    }

    public function updateApi(Template $template,$id)
    {
    	$this->authorize("update",Template::class);

    	request()->validate( [ 
            "name"=>"required|sometimes",
            "geo"=>"required|sometimes",
            "isActive"=>"required|sometimes",
            "theme_id"=>"required|sometimes",
            "group_id"=>"required|sometimes" ] );

    	$template->find($id)->update( [
         "name"=>request( "name" ),
            "geo"=>request("geo"),
            "isActive"=>request("isActive"),
            "theme_id"=>request("theme_id"),
            "group_id"=>request("group_id") ] );
    }

    public function destroyApi(Template $template,$id)
    {
    	$this->authorize("destroy",Template::class);

    	$template->find($id)->delete();
    }

    public function attachOfferToTemplate(Template $template)
    {
    	$template->find( request("template_id") )->offers()->attach( request("offer_id") );
    }

    public function detachOfferFromTemplate(Template $template)
    {
    	$template->find( request("template_id") )->offers()->detach( request("offer_id") );
    }

    public function templateOffers($id,Template $template)
    {
        $template = $template->find($id);
    	$offers = $template->offers()->where("group_id",$template->group_id)->get();
    	return OfferResource::collection($offers);
    }

}
