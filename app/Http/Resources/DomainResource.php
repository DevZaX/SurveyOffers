<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DomainResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return 
        [
            "id" => $this->id,
            "name" => $this->name,
            "group_id" => $this->group_id,
            "group" => $this->group,
            "created_at" => $this->created_at->format("M,d/Y"),
            "isActive"=>$this->isActive
        ];
    }
}
