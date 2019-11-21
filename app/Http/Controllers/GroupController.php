<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Resources\GroupResource;

class GroupController extends Controller
{
    public function __construct()
    {
    	$this->middleware("authMiddleware");
    }

    public function index()
    {
    	$this->authorize("index",Group::class);
    	return view("groups.index");
    }

    public function indexApi(Group $group)
    {
    	$this->authorize("index",Group::class);
    	$groups = $group->where("name","like",request("filter")."%")->paginate(10);
    	return GroupResource::collection($groups);
    }

    public function storeApi(Group $group)
    {
    	$this->authorize("store",Group::class);

    	request()->validate( [ "name"=>"required" ] );

    	$group->create( [ "name"=>request("name") ] );
    }

    public function updateApi(Group $group,$id)
    {
    	$this->authorize("update",Group::class);

    	request()->validate( [ "name"=>"required" ] );

    	$group->find($id)->update( [ "name"=>request( "name" ) ] );
    }

    public function destroyApi(Group $group,$id)
    {
    	$this->authorize("destroy",Group::class);

    	$group->find($id)->delete();
    }
}
