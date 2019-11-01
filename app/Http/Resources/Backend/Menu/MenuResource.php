<?php

namespace App\Http\Resources\Backend\Menu;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'nickname'    => $this->nickname,
            'items_count' => $this->items_count,
            'tree'        => $this->when($this->tree, function () {
                return MenuItemResource::collection($this->tree);
            }),
        ];
    }
}
