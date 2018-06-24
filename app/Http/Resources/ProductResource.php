<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'vendor_id' => $this->vendor_id,
            'dealer_id' => $this->dealer_id,
            'category_id' => $this->category_id,
            'price' => $this->price,
            'width' => $this->width,
            'height' => $this->height,
            'depth' => $this->depth,
            'weight' => $this->weight,
            'name' => $this->name,
            'quantity' => $this->quantity,
            'attributes' => AttributesResource::collection($this->whenLoaded('attributes')),
        );
    }
}
