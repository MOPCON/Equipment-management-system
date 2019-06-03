<?php

namespace App\Http\Requests;

class RoleRequest extends BaseRequest
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
            $id = explode('/', $this->path())[2];

            return [
                'name'        => 'required|string|unique:roles,name,' . $id,
                'permissions' => 'present|array',
            ];
        }

        return [
            'name'        => 'required|string|unique:roles',
            'permissions' => 'present|array',
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
            'name'        => '名稱',
            'permissions' => '權限',
        ];
    }
}
