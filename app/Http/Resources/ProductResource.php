<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
        return [
            'id'=> $this->id,
            'name'=> $this->name,
            'kg' => $this->kg,
            'short' => $this->short,
            'sale_price' => $this->sale_price,
            'description' => $this->description,
            'image' => $this->image,
            'barcode' => $this->barcode,
            'price' => $this->price,
            'grossTotal' => $this->grossTotal,
            'quantity' => $this->quantity,
            'created_at' => $this->created_at,
            'image_url' => Storage::url($this->image)
        ];
    }
}
