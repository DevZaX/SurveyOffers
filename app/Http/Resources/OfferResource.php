<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id"=>$this->id,
            "offer_name"=>$this->offer_name,
            "status"=>$this->status,
            "category"=>$this->category,
            "url"=>$this->url,
            "image_path"=>$this->image_path,
            "products_available"=>$this->products_available,
            "market_price"=>$this->market_price,
            "today_price"=>$this->today_price,
            "stars"=>$this->stars,
            "users_number"=>$this->users_number,
            "currency"=>$this->currency,
            "created_at"=>$this->created_at->format("M,d/Y"),
            "user"=>$this->user,
            "group"=>$this->group,
            "source"=>$this->source,
            "geo"=>$this->geo,
            "group_id"=>$this->group_id,
            //"shippingPrice"=>$this->shippingPrice,
        ];
    }
}
