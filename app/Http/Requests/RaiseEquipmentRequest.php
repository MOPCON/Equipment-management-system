<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;

class RaiseEquipmentRequest extends BaseRequest
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
