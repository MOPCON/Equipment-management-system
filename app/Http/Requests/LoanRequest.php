<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Controllers\ApiTrait;

class LoanRequest extends FormRequest
{
    use ApiTrait;

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
            'amount'            => 'required|integer',
        ];
    }

    /**
     * Use json output error message.
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->return400Response((string) $validator->messages()->first()));
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'staff_id'          => '員工',
            'staff_barcode'     => '員工條碼',
            'equipment_id'      => '器材',
            'equipment_barcode' => '器材條碼',
            'amount'            => '數量',
        ];
    }
}
