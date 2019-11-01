<?php

namespace App\Http\Resources\Backend\Menu;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemResource extends JsonResource
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
            'id'              => $this->id,
            'name'            => $this->name,
            'type'            => $this->type,
            'link'            => $this->link,
            'icon'            => $this->icon,
            'just_icon'       => $this->just_icon,
            'html_attributes' => $this->html_attributes,
            'meta'            => $this->meta,
            'active'          => $this->active,
            'show'            => $this->show,
            'children'        => static::collection($this->children),
        ];
    }
}
