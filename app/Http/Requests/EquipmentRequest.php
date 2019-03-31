<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;

class EquipmentRequest extends BaseRequest
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
                'name'       => 'required|string',
                'source'     => 'nullable|string',
                'memo'       => 'nullable|string',
                'amount'     => 'required|integer',
                'hasBarcode' => 'required',
                'prefix'     => 'required_if:hasBarcode,1|nullable|string|unique:equipments,prefix,' . $id,
            ];
        }

        return [
            'name'       => 'required|string',
            'source'     => 'nullable|string',
            'memo'       => 'nullable|string',
            'amount'     => 'required|integer',
            'hasBarcode' => 'required',
            'prefix'     => 'required_if:hasBarcode,1|nullable|string|unique:equipments,prefix',
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
            'name'       => '名稱',
            'source'     => '來源',
            'memo'       => '備註',
            'amount'     => '數量',
            'hasBarcode' => '是否需要條碼',
            'prefix'     => '條碼前綴',
        ];
    }
}
