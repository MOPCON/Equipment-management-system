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
            'year'                         => 'nullable|date_format:Y',
            'sponsor_type'                 => 'nullable|integer|min:0|max:' . count(Sponsor::$sponsorTypeItem),
            'sponsor_status'               => 'nullable|integer|min:0|max:' . count(Sponsor::$sponsorStatusItem),
            'name'                         => 'required|string',
            'en_name'                      => 'nullable|string',
            'introduction'                 => 'nullable|string',
            'en_introduction'              => 'nullable|string',
            'website'                      => 'nullable|url',
            'social_media'                 => 'nullable|url',
            'production'                   => 'nullable|string',
            'logo_path'                    => 'nullable|mimes:jpeg,png,gif,bmp,svg,pdf,ai,eps,psd,zip,rar|max:3096',
            'cloud_logo_path'              => 'nullable|url',
            'service_photo_path'           => 'nullable|mimes:jpeg,png,gif,bmp,svg,pdf,ai,eps,psd,zip,rar|max:3096',
            'cloud_service_photo_path'     => 'nullable|url',
            'promote'                      => 'nullable|string',
            'slide_path'                   => 'nullable|mimes:jpeg,png,gif,bmp,svg,pdf,ai,eps,psd,zip,rar|max:3096',
            'cloud_service_photo_path'     => 'nullable|url',
            'board_path'                   => 'nullable|mimes:jpeg,png,gif,bmp,svg,pdf,ai,eps,psd,zip,rar|max:3096',
            'cloud_board_path'             => 'nullable|url',
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
            'advence_icck_ad_path'               => 'nullable|mimes:jpeg,png,gif,bmp,svg,pdf,ai,eps,psd,zip,rar|max:3096',
            'cloud_advence_icck_ad_path'         => 'nullable|url',
            'advence_registration_ad_path'       => 'nullable|mimes:jpeg,png,gif,bmp,svg,pdf,ai,eps,psd,zip,rar|max:3096',
            'cloud_advence_registration_ad_path' => 'nullable|url',
            'advence_keynote'                    => 'nullable|string',
            'advence_hall_flag_path'             => 'nullable|mimes:jpeg,png,gif,bmp,svg,pdf,ai,eps,psd,zip,rar|max:3096',
            'cloud_advance_hall_flag_path'       => 'nullable|url',
            'advence_main_flow_flag_path'        => 'nullable|mimes:jpeg,png,gif,bmp,svg,pdf,ai,eps,psd,zip,rar|max:3096',
            'cloud_advence_main_flow_flag_path'  => 'nullable|url',
            'note'                               => 'nullable|string',
            'promotion_ad_media_link'            => 'nullable|url',
            'promotion_warm_up_media_link'       => 'nullable|url',
            'promotion_discord_intro'            => 'nullable|string',
            'promotion_email_short'              => 'nullable|string',
            'promotion_email_url'                => 'nullable|url',
            'promotion_email_image'              => 'nullable|url',
            'promotion_gather_town_h_link'       => 'nullable|url',
            'promotion_gather_town_v_link'       => 'nullable|url',
            'promotion_gather_town_video_link'   => 'nullable|url',
            'promotion_gather_town_video_link_0'   => 'nullable|url',
            'promotion_gather_town_video_link_1'   => 'nullable|url',
            'updated_by'                         => 'nullable|string',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        $attrs = [
            'year'                         => __('sponsor.year'),
            'sponsor_type'                 => __('sponsor.advance.sponsor_type'),
            'sponsor_status'               => '狀態',
            'name'                         => __('sponsor.main.name'),
            'en_name'                      => __('sponsor.main.en_name'),
            'introduction'                 => __('sponsor.main.introduction'),
            'en_introduction'              => __('sponsor.main.en_introduction'),
            'website'                      => __('sponsor.main.website'),
            'social_media'                 => __('sponsor.main.social_media'),
            'production'                   => __('sponsor.main.production'),
            'logo_path'                    => __('sponsor.main.logo'),
            'service_photo_path'           => __('sponsor.main.service_photo'),
            'promote'                      => __('sponsor.main.promotion'),
            'slide_path'                   => __('sponsor.main.slide'),
            'board_path'                   => __('sponsor.main.board'),
            'opening_remarks'              => __('sponsor.main.dinner_intro'),
            'recipe_full_name'             => __('sponsor.recipe.company_full_name'),
            'recipe_tax_id_number'         => __('sponsor.recipe.tax_id_number'),
            'recipe_amount'                => __('sponsor.recipe.sponse_price'),
            'recipe_contact_name'          => __('sponsor.recipe.contact_name'),
            'recipe_contact_title'         => __('sponsor.recipe.contact_title'),
            'recipe_contact_phone'         => __('sponsor.recipe.contact_phone_number'),
            'recipe_contact_email'         => __('sponsor.recipe.contact_mail'),
            'recipe_contact_address'       => __('sponsor.recipe.contact_address'),
            'reason'                       => __('sponsor.main.sponse_reason'),
            'purpose'                      => __('sponsor.main.sponse_aims'),
            'remark'                       => __('sponsor.main.sponse_remarks'),
            'advence_icck_ad_path'         => __('sponsor.advance.icck'),
            'advence_registration_ad_path' => __('sponsor.advance.registration'),
            'advence_keynote'              => __('sponsor.advance.keynote'),
            'advence_hall_flag_path'       => __('sponsor.advance.hall_flag'),
            'advence_main_flow_flag_path'  => __('sponsor.advance.main_flow_flag'),
            'note'                         => '後台備註',
            'updated_by'                   => '最後更新者',
        ];

        return collect($attrs)
            ->map(function ($item) {
                return preg_replace('!\s\(.*\)!', '', $item);
            })->all();
    }
}
