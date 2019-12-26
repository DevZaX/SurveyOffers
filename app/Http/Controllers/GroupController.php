<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Resources\GroupCollection;
use App\Http\Resources\GroupResource;
use Carbon\Carbon;

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

    public function filter($model)
    {
        if(request("groupName")!="") $model=$model->where("name",request("groupName"));
        if(request("groupCreated")!="") $model=$model->whereBetween("created_at",[
            Carbon::parse(request("groupCreated"))->startOfDay(),
            Carbon::parse(request("groupCreated"))->endOfDay(),
        ]);

        return $model
        ->orderBy(request("sortBy"),request("sortType"))
        ->paginate(request("limit"));
    }

    public function indexApi(Group $group)
    {
    	$this->authorize("index",Group::class);
    	$groups = $this->filter($group);
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
