<?php

namespace App\Http\Requests;

class TelegramMessageRequest extends BaseRequest
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
            'now_send'     => 'required|boolean',
            'es_time'      => 'required_if:now_send,0',
            'channel_ids'   => 'required|array',
            'display_name' => '',
            'content'      => 'required',
        ];
    }
}
