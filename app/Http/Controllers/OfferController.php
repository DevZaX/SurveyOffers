<?php

namespace App\Http\Controllers;

use App\Http\Resources\OfferCollection;
use App\Http\Resources\OfferResource;
use App\Offer;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OfferController extends Controller
{

    public function __construct(){
        $this->middleware("authMiddleware")->except("offers");
    }
   
    public function index()
    {
        return view('offers.index');
    }

    public function filter($model)
    {
       if( request("offerName") != "" ) $model = $model->where("offer_name","like","%".request("offerName")."%");
       if( request("status") != null ) $model = $model->where("status",request("status"));
       if( request("category") != "" ) $model = $model->where("category",request("category"));
       if( request("geo") != "" ) $model = $model->where("geo",request("geo"));
       if( request("group_id") != "" ) $model = $model->where("group_id",request("group_id"));
       if( request("created") != "" ) $model = $model
        ->whereBetween("created_at",[
            Carbon::parse(request("created"))->startOfDay(),
            Carbon::parse(request("created"))->endOfDay()
        ]);
       if( request("source") != "" ) $model = $model->where("source","like","%".request("source")."%");

       return $model
       ->orderBy(  request("sortBy"),request("sortType") )
       ->paginate(request("limit"));
    }

    public function indexApi(Offer $offer){
        if(auth()->user()->superAdmin) $offers = $this->filter($offer);
        else $offers = $this->filter(auth()->user()->group->offers());
        $offerCollection = new OfferCollection($offers);
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
            "source"=>"required",
            "geo"=>"required",
            //"shippingPrice"=>"required",
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
            "source"=>request("source"),
            "geo"=>request("geo"),
            //"shippingPrice"=>request("shippingPrice"),
       ]);
    }

    public function destroyApi(Offer $offer,$id){

        $offer = $offer->find($id);

        $this->authorize("destroy",$offer);

        $offer->delete();
    }

    public function updateApi(Offer $offer,$id){

        $offer = $offer->find($id);

        //$this->authorize("update",$offer);

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
            "source"=>"required|sometimes",
            "geo"=>"required|sometimes",
            //"shippingPrice"=>"required|sometimes",
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


    public function all(Offer $offer)
    {
        $listOffers = Collect( request("listOffers") )->pluck("id");
        if( auth()->user()->superAdmin )
        {
            $offers = $offer
            ->whereNotIn("id",$listOffers)
            ->where("geo",request("geo"))
            ->where("group_id",request("group_id"))
            ->where("offer_name","like","%".request("filteredOffer")."%")
            ->paginate(10);
        }
        else 
        {
            $offers = auth()->user()->group->offers()
             ->whereNotIn("id",$listOffers)
             ->where("geo",request("geo"))
             ->where("group_id",request("group_id"))
            ->where("offer_name","like","%".request("filteredOffer")."%")
            ->paginate(10);
        }
        
        return OfferResource::collection($offers);
    }


    public function offers()
    {
        $validator = \Validator::make( request()->all(),[
            "g" => "required",
            "t" => "required",
            "tmp" => "required"
        ] );

        if( $validator->fails() ) return response()->json(["offers"=>[]]);

        $offers = \DB::table("offers")
        ->join("offer_template","offers.id","=","offer_template.offer_id")
        ->join("templates","templates.id","=","offer_template.template_id")
        ->where("templates.geo",request("t"))
        ->where("templates.group_id",request("g"))
        ->where("offers.status",1)
        ->where("templates.id",request("tmp"))
        ->select("offers.*")
        ->get();

        return response()->json(["offers"=>$offers]);
    }


  

   
}
