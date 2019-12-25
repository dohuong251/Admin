<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UstvChannelRequest extends FormRequest
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
            "symbol" => "required",
            "id_type_tv" => "required"
        ];
    }
}
