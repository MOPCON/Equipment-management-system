<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\ApiTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends BaseRequest
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
        $path = explode("/", $this->path());
        if ($this->getMethod() == 'POST') {
            $type = $path[2] ?? '';
            if ($type === "password") {
                return [
                    'password_confirmation' => 'required',
                    'password'              => 'required|string|min:8|confirmed',
                ];
            }

            return [
                'name'                  => 'required|string',
                'email'                 => 'required|email|unique:users,email',
                'password_confirmation' => 'required',
                'password'              => 'required|string|min:8|confirmed',
            ];
        } else {
            $id = $path[2];

            return [
                'name'  => 'required|string',
                'email' => 'required|email|unique:users,email,' . $id,
            ];
        }
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
            'password' => '密碼',
        ];
    }
}
