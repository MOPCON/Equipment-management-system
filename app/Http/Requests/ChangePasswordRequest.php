<?php

namespace App\Http\Requests;

class ChangePasswordRequest extends BaseRequest
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
            'old_password'          => 'required|string',
            'password'              => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string',
        ];
    }

    public function attributes()
    {
        return [
            'old_password'          => '舊密碼',
            'password'              => '新密碼',
            'password_confirmation' => '新密碼確認',
        ];
    }
}
