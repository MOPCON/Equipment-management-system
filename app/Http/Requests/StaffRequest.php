<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
                'email'    => 'required|email',
                'phone'    => 'required|string',
                'group_id' => 'required',
                'role'     => 'required',
            ];
        }
        return [
            'name'     => 'required|string',
            'email'    => 'required|email',
            'phone'    => 'required|string',
            'group_id' => 'required',
            'barcode'  => 'required|string',
            'role'     => 'required',
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
