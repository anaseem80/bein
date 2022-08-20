<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogsResource extends JsonResource
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
            'content'=>$this->content,
            'image'=>$this->image,
            'is_published'=>$this->is_published,
            'created_by'=>$this->user,
            'categories'=>$this->categories,
            'created_at'=>$this->created_at,
            'comments'=>$this->comments,
        ];
    }
}
