<?php

namespace App\Http\Controllers;

use App\Domain;
use App\Http\Resources\DomainCollection;
use App\Http\Resources\DomainResource;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function __construct()
    {
        $this->middleware("authMiddleware");
    }
    
     public function index()
    {
    	$this->authorize("index",Domain::class);
    	return view("domains.index");
    }

    public function indexApi(Domain $domain)
    {
    	$this->authorize("index",Domain::class);
    	$domains = $domain->where("name","like","%".request("filter")."%")->paginate(10);
    	return new DomainCollection($domains);
    }

    public function storeApi(Domain $domain)
    {
    	$this->authorize("store",Domain::class);

    	request()->validate( [ "name"=>"required|unique:domains","group_id"=>"required" ] );

    	$domain->create( [ "name"=>request("name"),"group_id"=>request("group_id") ] );
    }

    public function updateApi(Domain $domain,$id)
    {
        

    	$this->authorize("update",Domain::class);

    	request()->validate( [ "name"=>"required|sometimes","group_id"=>"required|sometimes" ,"isActive"=>"required|sometimes"] );

    	$domain->find($id)->update( [ "name"=>request( "name" ),"group_id"=>request("group_id"),"isActive"=>request("isActive") ] );
    }

    public function destroyApi(Domain $domain,$id)
    {
    	$this->authorize("destroy",Domain::class);

    	$domain->find($id)->delete();
    }

    public function getDomainByGroupId(Domain $domain,$id)
    {
    	$this->authorize("index",Domain::class);
    	$domain = $domain->where("group_id",$id)->where("isActive",1)->first();
    	if(!$domain) return response()->json(null);
    	return new DomainResource($domain);
    }

}
