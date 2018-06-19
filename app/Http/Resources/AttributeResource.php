<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttributeResource extends JsonResource
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
            'product_id' => $this->product_id,
            'category_id' => $this->category_id,
            'attribute_name_id' => $this->attribute_name_id,
            'value' => $this->value,
        );
    }
}
