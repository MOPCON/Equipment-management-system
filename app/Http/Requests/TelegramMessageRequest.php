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
            "now_send"     => "required|boolean",
            "sending_time" => "required_if:now_send,0|date",
            "channel_id"   => 'required|exists:telegram_channels,id',
            "display_name" => "string",
            "content"      => "required",
        ];
    }
}
