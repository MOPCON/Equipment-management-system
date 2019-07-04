<?php

namespace App\Http\Requests;

use App\Speaker;
use Illuminate\Contracts\Validation\Validator;

class SpeakerRequest extends BaseRequest
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
            'name' => 'required|string',
            'name_e' => 'nullable|string|max:100',
            'company' => 'nullable|string|max:100',
            'job_title' => 'nullable|string|max:100',
            'bio' => 'nullable|string|max:120',
            'bio_e' => 'nullable|string|max:240',
            'file' => 'nullable|image',
            'link_fb' => 'nullable|url',
            'link_github' => 'nullable|url',
            'link_twitter' => 'nullable|url',
            'link_other' => 'nullable|url',
            'topic' => 'nullable|string|max:32',
            'topic_e' => 'nullable|string|max:64',
            'summary' => 'nullable|string|max:240',
            'summary_e' => 'nullable|string|max:480',
            'tag' => 'nullable|array',
            'level' => 'nullable|integer|min:0|max:' . count(Speaker::$levelItem),
            'license' => 'nullable|integer|min:0|max:' . count(Speaker::$licenseItem),
            'promotion' => 'nullable|boolean',
            'tshirt_size' => 'nullable|integer|min:0|max:' . count(Speaker::$tshirtSizeItem),
            'need_parking_space' => 'nullable|boolean',
            'has_dinner' => 'nullable|boolean',
            'meal_preference' => 'nullable|integer|min:0|max:' . count(Speaker::$mealPreferenceItem),
            'has_companion' =>  'nullable|integer|min:0|max:10',
            'speaker_status' => 'nullable|integer|min:0|max:' . count(Speaker::$speakerStatusItem),
            'speaker_type' => 'nullable|integer|min:0|max:' . count(Speaker::$speakerTypeItem),
            'note' => 'nullable|string',
            'last_edited_by' => 'nullable|string',
        ];
    }
}
