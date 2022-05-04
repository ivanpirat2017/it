<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id' => $this->id,
            'code' => $this->code,
            'user' => UserResource::make($this->user_id),
            'id_order_statuse' => [
                'id' =>$this->status_id->id,
                'name_status' =>$this->status_id->name_status
            ],
            'price' => $this->price,
            'json_cart' => $this->json_cart_decode($this->json_cart),
        ];
    }
}
