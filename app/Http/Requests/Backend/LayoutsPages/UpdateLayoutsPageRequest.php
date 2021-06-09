<?php

namespace App\Http\Requests\Backend\LayoutsPages;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLayoutsPageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('edit-layoutspage');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'layout_title' => ['required', 'max:191', 'unique:layouts_pages,layout_title'],
            'layout_image' => ['required', 'image', 'mimes:jpg,png,jpeg,gif,svg'],
            
        ];
    }
}
