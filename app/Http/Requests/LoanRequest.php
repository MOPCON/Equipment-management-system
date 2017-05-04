<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanRequest extends FormRequest
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
            'staff_id'          => 'required|integer',
            'staff_barcode'     => 'required_if:staff_id,0|string',
            'equipment_id'      => 'required|integer',
            'equipment_barcode' => 'required_if:equipment_id,0|string',
            'amount'            => 'required|integer'
        ];
    }

    /**
     * Use json output error message.
     */
    public function response(array $errors)
    {
        return \App\Services\ApiService::returnApiResponse(
            $errors[array_keys($errors)[0]][0],
            [],
            false,
            400
        );
    }
}
