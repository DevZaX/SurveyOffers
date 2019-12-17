<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ThemeResource extends JsonResource
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
            "id"=>$this->id,
            "name"=>$this->name,
            "status"=>$this->status,
            "created_at"=>$this->created_at->format("M,d/Y"),
            "geo"=>$this->geo,
            "theme_preview"=>$this->theme_preview,
        ];
    }
}
