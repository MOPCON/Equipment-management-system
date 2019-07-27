<?php

namespace App\Http\Requests;

use App\Sponsor;
use Illuminate\Contracts\Validation\Validator;

class SponsorRequest extends BaseRequest
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
            'sponsor_type'                 => 'nullable|integer|min:0|max:' . count(Sponsor::$sponsorTypeItem),
            'sponsor_status'               => 'nullable|integer|min:0|max:' . count(Sponsor::$sponsorStatusItem),
            'name'                         => 'required|string',
            'en_name'                      => 'nullable|string',
            'introduction'                 => 'nullable|string',
            'en_introduction'              => 'nullable|string',
            'website'                      => 'nullable|url',
            'social_media'                 => 'nullable|url',
            'production'                   => 'nullable|string',
            'logo_path'                    => 'nullable|mimes:jpeg,png,gif,bmp,svg,pdf,ai,eps,psd',
            'service_photo_path'           => 'nullable|image',
            'promote'                      => 'nullable|string',
            'slide_path'                   => 'nullable|image',
            'board_path'                   => 'nullable|image',
            'opening_remarks'              => 'nullable|string',
            'recipe_full_name'             => 'nullable|string',
            'recipe_tax_id_number'         => 'nullable|string',
            'recipe_amount'                => 'nullable|integer',
            'recipe_contact_name'          => 'nullable|string',
            'recipe_contact_title'         => 'nullable|string',
            'recipe_contact_phone'         => 'nullable|string',
            'recipe_contact_email'         => 'nullable|string',
            'recipe_contact_address'       => 'nullable|string',
            'reason'                       => 'nullable|string',
            'purpose'                      => 'nullable|string',
            'remark'                       => 'nullable|string',
            'advence_icck_ad_path'         => 'nullable|image',
            'advence_registration_ad_path' => 'nullable|image',
            'advence_keynote'              => 'nullable|string',
            'advence_hall_flag_path'       => 'nullable|image',
            'advence_main_flow_flag_path'  => 'nullable|image',
            'note'                         => 'nullable|string',
            'updated_by'                   => 'nullable|string',
        ];
    }
}
