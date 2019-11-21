<?php

namespace App\Http\Controllers;

use App\Http\Resources\OfferResource;
use App\Http\Resources\GroupResource;
use App\Offer;
use App\group;
use Illuminate\Http\Request;

class OfferController extends Controller
{

    public function __construct(){
        $this->middleware("authMiddleware");
    }
   
    public function index()
    {
        return view('offers.index');
    }

    public function indexApi(Offer $offer){
        if(auth()->user()->superAdmin) $offers = $offer
            ->where("offer_name","like","%".request("filter")."%")
            ->where("status","like","%".request("status")."%")
            ->paginate(10);
        else $offers = auth()->user()->offers()
            ->where("offer_name","like","%".request("filter")."%")
            ->where("status","like","%".request("status")."%")
            ->paginate(10);
        $offerCollection = OfferResource::collection($offers);
        return response($offerCollection);
    }

    public function storeApi(){

       request()->validate([

            "offer_name"=>"required",
            "category"=>"required",
            "url"=>"required",
            "image_path"=>"required",
            "products_available"=>"required|integer",
            "market_price"=>"required",
            "today_price"=>"required",
            "stars"=>"required|integer",
            "users_number"=>"required|integer",
            "currency"=>"required",
            "status"=>"boolean",
            "group_id"=>"required",
       ]);

       auth()->user()->offers()->create([
            "offer_name"=>request("offer_name"),
            "status"=>0,
            "category"=>request("category"),
            "url"=>request("url"),
            "image_path"=>request("image_path"),
            "products_available"=>request("products_available"),
            "market_price"=>request("market_price"),
            "today_price"=>request("today_price"),
            "stars"=>request("stars"),
            "users_number"=>request("users_number"),
            "currency"=>request("currency"),
            "group_id"=>request("group_id"),
       ]);
    }

    public function destroyApi(Offer $offer,$id){

        $offer = $offer->find($id);

        $this->authorize("destroy",$offer);

        $offer->delete();
    }

    public function updateApi(Offer $offer,$id){

        $offer = $offer->find($id);

        $this->authorize("update",$offer);

        request()->validate([

            "offer_name"=>"required|sometimes",
            "category"=>"required|sometimes",
            "url"=>"required|sometimes",
            "image_path"=>"required|sometimes",
            "products_available"=>"required|integer|sometimes",
            "market_price"=>"required|sometimes",
            "today_price"=>"required|sometimes",
            "stars"=>"required|integer|sometimes",
            "users_number"=>"required|integer|sometimes",
            "currency"=>"required|sometimes",
            "status"=>"boolean|sometimes",
            "group_id"=>"required|sometimes",
       ]);

        $offer->update(request()->all());

    }

    public function action($action)
    {
        if($action=="activate")
        {
            \DB::table("offers")->whereIn("id",request()->all())->update(["status"=>1]);
        }
        if($action=="deactivate")
        {
            \DB::table("offers")->whereIn("id",request()->all())->update(["status"=>0]);
        }
    }


    public function groups(Group $group)
    {
        $groups = $group->all();
        return GroupResource::collection($groups);
    }

   
}
