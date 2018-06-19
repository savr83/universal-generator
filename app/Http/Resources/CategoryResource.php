<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array(
            'id'   => $this->id,
            'parent_id' => $this->parent_id,
            'name' => $this->name,
            'products' => ProductsResource::collection($this->products),
            'test' => 'test',
        );
    }
}
