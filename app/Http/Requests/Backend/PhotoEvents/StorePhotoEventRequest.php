<?php

namespace App\Http\Requests\Backend\PhotoEvents;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StorePhotoEventRequest.
 */

class StorePhotoEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('create-event');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'event_title'           => ['required', 'unique:photo_events,event_title'],  
            'event_backendbg_image' => ['required'],
            'event_backendbg_image' => ['required'],
            'event_host'            => ['required'],
            'status'                => ['boolean'],
            'event_collage'         => ['required'],
            

        ];
    }
}
