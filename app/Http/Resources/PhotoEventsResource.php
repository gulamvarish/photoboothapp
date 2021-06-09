<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PhotoEventsResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'event_title' => $this->event_title,          
            'event_backendbg_image' => $this->event_bg_image,
            'event_forntbg_image' => $this->event_forntbg_image,
            'event_sound'=> $this->event_sound,
            'event_qrcode' => $this->event_qrcode,           
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            

            
        ];
    }
}
