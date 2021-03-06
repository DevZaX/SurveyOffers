<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DomainCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
         return 
        [
            "data"=>DomainResource::collection($this->collection),
            "currentPage"=>$this->currentPage(),
            "perPage"=>$this->perPage(),
            "numberOfPages"=>ceil($this->total()/$this->perPage()),
            "lastPage"=>$this->lastPage(),
        ];
    }
}
