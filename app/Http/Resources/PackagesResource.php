<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'description'=>$this->description,
            'parent_id'=>$this->parent_id,
            'image'=>$this->image,
            'price_90'=>$this->price_90,
            'price_180'=>$this->price_180,
            'price_365'=>$this->price_365,
            'created_by'=>$this->user,
            'is_offer'=>$this->is_offer,
            'subPackages'=>$this->subPackages,
            'parentPackage'=>$this->parentPackage,
            'devices'=>$this->devices,
            'channels'=>$this->channels,
            'channelImages'=>$this->channelImages,
            'created_at'=>$this->created_at,
            'comments'=>$this->comments,

        ];
    }
}
