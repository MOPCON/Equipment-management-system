<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EquipmentRequest extends FormRequest
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
            'name'       => 'required|string',
            'source'     => 'string',
            'memo'       => 'string',
            'amount'     => 'required|integer',
            'hasBarcode' => 'required',
            'prefix'     => 'required_if:hasBarcode,1|string',
        ];
    }
}
