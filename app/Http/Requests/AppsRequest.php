<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
            'icon_url' => 'required',
            'app_version_name' => 'required',
            'package_name' => 'required',
            'version_name' => 'required',
        ];
    }
}
