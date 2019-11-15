<?php

namespace App\Http\Controllers;

use App\Http\Resources\OfferResource;
use App\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
   
    public function index()
    {
        return view('offers.index');
    }

    public function indexApi(Offer $offer){
        $offers = $offer->paginate(10);
        $offerCollection = OfferResource::collection($offers);
        return response($offerCollection);
    }

    public function storeApi(Offer $offer){

       request()->validate([

            "offer_name"=>"required",
            "category"=>"required",
            "url"=>"required",
            "image_path"=>"required",
            "products_available"=>"required|integer",
            "market_price"=>"required|numeric",
            "today_price"=>"required|numeric",
            "stars"=>"required|integer",
            "users_number"=>"required|integer",
            "currency"=>"required",
            "status"=>"boolean",
       ]);

       $offer->create([
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
            "currency"=>request("currency")
       ]);
    }

    public function destroyApi(Offer $offer,$id){
        $offer->find($id)->delete();
    }

    public function updateApi(Offer $offer,$id){
        request()->validate([

            "offer_name"=>"required|sometimes",
            "category"=>"required|sometimes",
            "url"=>"required|sometimes",
            "image_path"=>"required|sometimes",
            "products_available"=>"required|integer|sometimes",
            "market_price"=>"required|numeric|sometimes",
            "today_price"=>"required|numeric|sometimes",
            "stars"=>"required|integer|sometimes",
            "users_number"=>"required|integer|sometimes",
            "currency"=>"required|sometimes",
            "status"=>"boolean|sometimes",
       ]);

        $offer->find($id)->update(request()->all());

    }

   
}
