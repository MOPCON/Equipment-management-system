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
            "sending_time" => "required|date",
            "channel_id"   => 'required|exists:telegram_channels,id',
            "display_name" => "required|string",
            "content"      => "required",
        ];
    }
}
