<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\ApiTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class RaiseEquipmentRequest extends FormRequest
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
        if ($this->getMethod() == 'PUT') {
            return [
                'name'     => 'required|string',
                'staff_id' => 'required|exists:staffs,id',
                'barcode'  => 'required|string',
                'status'   => 'required',
            ];
        }

        return [
            'name'     => 'required|string',
            'staff_id' => 'required|exists:staffs,id',
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
            'name'     => '名稱',
            'staff_id' => '出借者',
            'barcode'  => '條碼',
            'status'   => '狀態',
        ];
    }
}
