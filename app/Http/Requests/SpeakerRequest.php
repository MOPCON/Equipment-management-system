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
            'file' => 'nullable|dimensions:min_width=500,min_height=500',
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

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    // public function attributes()
    // {
    //     return [
    //         'name' => '姓名',
    //         'name_e' => '英文名稱',
    //         'company' => '公司/組織',
    //         'job_title' => '職稱',
    //         'bio' => '個人介紹',
    //         'bio_e' => '個人介紹(英文)',
    //         'photo' => '照片',
    //         'link_fb' => 'Facebook',
    //         'link_github' => 'Github',
    //         'link_twitter' => 'Twitter',
    //         'link_other' => '其他(如Website/Blog)',
    //         'topic' => '演講主題',
    //         'topic_e' => '演講主題(英文)',
    //         'summary' => '演講摘要',
    //         'summary_e' => '演講摘要(英文)',
    //         'tag' => '標籤',
    //         'level' => '難易度',
    //         'license' => '授權方式',
    //         'promotion' => '是否同意公開宣傳',
    //         'tshirt_size' => 'T-shirt 尺寸',
    //         'need_parking_space' => '您是否需有停車需求',
    //         'has_dinner' => '敬邀參加講者晚宴',
    //         'meal_preference' => '葷素食偏好',
    //         'has_companion' => '晚宴攜伴人數',
    //         'speaker_status' => '狀態',
    //         'speaker_type' => '類型',
    //         'note' => '備註',
    //         'last_edited_by' => '最後更新者',
    //     ];
    // }
}
