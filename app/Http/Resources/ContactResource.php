<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            'name' => $this->name,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'site' => $this->site,
            'location' => $this->location,
        );
    }
}
