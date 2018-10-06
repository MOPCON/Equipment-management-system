<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\ApiTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class StaffRequest extends BaseRequest
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
        if ($this->getMethod() == 'POST') {
            return [
                'name'     => 'required|string',
                'email'    => 'nullable|email',
                'phone'    => 'nullable|string',
                'duties'   => 'nullable|string',
                'group_id' => 'required',
                'role'     => 'required',
            ];
        }

        return [
            'name'     => 'required|string',
            'email'    => 'nullable|email',
            'phone'    => 'nullable|string',
            'duties'   => 'nullable|string',
            'group_id' => 'required',
            'barcode'  => 'required|string',
            'role'     => 'required',
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
            'email'    => '電子郵件地址',
            'phone'    => '電話',
            'group_id' => '組別',
            'barcode'  => '條碼',
            'role'     => '職位',
        ];
    }
}
