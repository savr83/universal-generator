<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DealerResource extends JsonResource
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
            'contact_id' => $this->contact_id,
            'name' => $this->name,
            'short_name' => $this->short_name,
        );
    }
}
