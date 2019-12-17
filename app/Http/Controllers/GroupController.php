<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Resources\GroupCollection;
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
    	return new GroupCollection($groups);
    }

    public function storeApi(Group $group)
    {
    	$this->authorize("store",Group::class);

    	request()->validate( [ "name"=>"required|unique:groups" ] );

    	$group->create( [ "name"=>request("name") ] );
    }

    public function updateApi(Group $group,$id)
    {
    	$this->authorize("update",Group::class);

    	request()->validate( [ "name"=>"required|sometimes" ] );

    	$group->find($id)->update( [ "name"=>request( "name" ) ] );
    }

    public function destroyApi(Group $group,$id)
    {
    	$this->authorize("destroy",Group::class);

    	$group->find($id)->delete();
    }


    public function all(Group $group)
    {
        $groups = $group->all();
        return GroupResource::collection($groups);
    }
}
