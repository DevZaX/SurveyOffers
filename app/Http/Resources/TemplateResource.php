<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TemplateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $s1 = base64_encode( "g=".$this->group_id."&t=".$this->geo."&tid=".$this->theme_id."&tmp=".$this->id );
        return 
        [ 
            "id" => $this->id,
            "geo" => $this->geo,
            "name" => $this->name,
            "created_at" => $this->created_at->format("M,d/Y"),
            "isActive" => $this->isActive,
            "offers" => $this->offers,
            "group_id"=>$this->group_id,
            "group" => $this->group,
            "theme_id"=>$this->theme_id,
            "domain"=>$this->domainName()."/?s1=".$s1."&trk=[trk]&clk=[clk]",
            //"domain"=>"http://".$this->domainName()."/?g=".$this->group_id."&t=".$this->geo."&tid=".$this->theme_id."&tmp=".$this->id."&trk=[trk]&clk=[clk]",
        ];
    }
}
