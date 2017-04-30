<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
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
            'name'           => 'required|string',
            'manager'        => 'required',
            'deputy_manager' => 'required',
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
