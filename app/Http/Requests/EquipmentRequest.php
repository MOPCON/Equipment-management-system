<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EquipmentRequest extends FormRequest
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
            $id = explode("/", $this->path())[2];
            return [
                'name'       => 'required|string',
                'source'     => 'string',
                'memo'       => 'string',
                'amount'     => 'required|integer',
                'hasBarcode' => 'required',
                'prefix'     => 'required_if:hasBarcode,1|string|unique:equipments,prefix,' . $id,
            ];
        }
        return [
            'name'       => 'required|string',
            'source'     => 'string',
            'memo'       => 'string',
            'amount'     => 'required|integer',
            'hasBarcode' => 'required',
            'prefix'     => 'required_if:hasBarcode,1|string|unique:equipments,prefix',
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
