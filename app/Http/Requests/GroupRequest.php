<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\ApiTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class GroupRequest extends FormRequest
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
            'name'           => 'required|string',
            'manager'        => 'required',
            'deputy_manager' => 'required',
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
            'name'           => '名稱',
            'manager'        => '組長',
            'deputy_manager' => '副組長',
        ];
    }
}
