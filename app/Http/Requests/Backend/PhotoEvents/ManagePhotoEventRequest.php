<?php

namespace App\Http\Requests\Backend\PhotoEvents;

use Illuminate\Foundation\Http\FormRequest;
/**
 * Class ManagePhotoEventRequest.
 */

class ManagePhotoEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('view-event');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
