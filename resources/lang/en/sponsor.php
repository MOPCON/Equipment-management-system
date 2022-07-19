<?php

return [
    'year'                => 'Year',
    'sponsor_form'        => 'Sponsor form',
    'sponsor_form_c'      => '贊助商表單',
    'sponsor_upload_form' => 'Sponsor Upload Data Form',
    'addition_title'      => 'Additional information',
    'second'              => 'second',
    'password'            => 'password',
    'submit'              => 'Submit',
    'promote_data'        => 'Promotional Data',
    'recipe_data'         => 'Recipe Information',
    'success_message'     => 'Upload successful',
    'fail_message'        => 'Checking field is filled correctly,please.',
    'main' => [
        'name'            => 'Company name (CH)',
        'en_name'         => 'Company name (EN)',
        'introduction'    => 'Company introduction (EN)',
        'en_introduction' => 'Company introduction (CH)',
        'website'         => 'Website URL',
        'social_media'    => 'Social media (e.g.,FB)',
        'production'      => 'Product introduction (main product, service, technic, expertise)',
        'logo'            => 'Logo (prefer ai file)',
        'service_photo'   => 'Product or service photo',
        'promotion'       => 'Promotion contents for social media like our fan page.',
        'slide'           => 'Session intervals slides ( 1920 x 1080 px ).',
        'board'           => 'Digital Board ( 1920 x 1080 px ).',
        'dinner_intro'    => 'Company introduction in banquet.',
        'sponse_reason'   => 'Expectations or missions for participating the sponsorship program.',
        'sponse_aims'     => 'Goals to achive for participating our event.',
        'sponse_remarks'  => 'Comments'
    ],
    'recipe' => [
        'company_full_name'    => 'Customer name',
        'tax_id_number'        => 'Tax ID number',
        'sponse_price'         => 'Sponsorship Package',
        'contact_name'         => 'Contact person name',
        'contact_title'        => 'Contact person title',
        'contact_phone_number' => 'Contact person phone',
        'contact_mail'         => 'Contact person email',
        'contact_address'      => 'Recipient address',
        'contact_address_placeholder' => 'Please field the valid address',
    ],
    'advance' => [
        'sponsor_type'   => 'Sponsor type',
        'gather_town'    => 'Gather town',
        'promotion_gather_town_h_link' => 'Horizontal image',
        'promotion_gather_town_v_link' => 'Vertical image',
        'promotion_gather_town_video_link' => 'Promotion video ( YouTube link )',
        'email_before_start' => 'Publicize in pre-departure notice mail',
        'icck'           => 'ICCK entrance full frame Ad',
        'registration'   => 'MOPCON entrance full frame Ad',
        'keynote'        => 'Introduction in keynote session',
        'hall_flag'      => 'Flag banners in venues',
        'main_flow_flag' => 'Flag banners at the main aisle',
        'tony_stark'     => 'Universe',
        'bruce_wayne'    => 'Galaxy',
        'hacker'         => 'Planet',
        'developer'      => 'Comet',
        'promotion_ad_media_link'         => 'Ad play',
        'promotion_warm_up_media_link' => 'Warm-up Animation',
        'promotion_discord_intro' => 'Introduction of Discord stall',
        'promotion_email_short' => 'Introduction of company or event',
        'promotion_email_url' => 'Publicize url',
        'promotion_email_image' => 'Publicity photo',
    ],
    'subtitle' => [
        'introduction'    => 'Provide company’s background and mission. (in 250 words)',
        'production'      => 'Describe your products, servicesor technical background.  (in 250 words)',
        'logo'            => 'We’ll prefer the AI format, otherwise please provide image resolution at least 1920*1080. If you have multiple images, you can zip them all in a single file.',
        'promotion'       => 'Please provide the content that you would like to share on MOPCON’s fan page.',
        'service_photo'   => 'Please provide your products or services images.',
        'slide'           => '用於休息時間投影，建議 1920x1080px JPG/PNG圖片檔',
        'board'           => '用於會場電視螢幕，建議 1920x1080px JPG/PNG圖片檔',
        'sponse_aims'     => 'Please describe the goal your company wants to achieve in MOPCON. (e.g. communicate more, promote your products or services, etc...)',
        'icck'            => '寬305cmx高900cm+出血0.5cm 解析度150-200dpi (AI/PSD) ',
        'registration'    => '寬300cmx高250cm+出血0.5cm 解析度150-200dpi (AI/PSD) ',
        'keynote'         => 'This will be announced by the host before the session. (in 150 words)',
        'hall_flag'       => '寬55cmx高200cm+出血0.5cm 解析度150-200dpi (AI/PSD/JPG/PNG)',
        'main_flow_flag'  => '寬55cmx高200cm+出血0.5cm 解析度150-200dpi (AI/PSD/JPG/PNG)',
        'promotion_ad_media_link' => 'It can be image or video',
        'promotion_warm_up_media_link' => 'It can be image or video',
        'promotion_discord_intro' => 'Please provide company\'s introduction for stall',
        'promotion_email_short' => 'about 100 characters',
        'promotion_email_url' => 'It can be official website or publicize url',
        'promotion_gather_town_h_link' => 'Horizontal image 700*300',
        'promotion_gather_town_v_link' => 'Vertical image 180*500',
        'promotion_gather_town_video_link' => 'Please provide YouTube link.'
    ],
    'required' => [
        'main_name'                   => 'Company name (CH) is required',
        'main_en_name'                => 'Company name (EN) is required',
        'main_introduction'           => 'Company introduction (EN) is required',
        'main_website'                => 'Website URL is required',
        'main_production'             => 'Product or service introduction is required',
        'main_logo'                   => 'Please upload logo image',
        'main_service_photo'          => 'Please upload product or service photo',
        'main_slide'                  => 'Please upload intermission image',
        'main_board'                  => 'Please upload digital signage image',
        'recipe_company_full_name'    => 'Full company name is required',
        'recipe_tax_id_number'        => 'Tax ID number is required',
        'recipe_sponse_price'         => 'Sponsorship amount is required',
        'recipe_contact_name'         => 'Contact person name is required',
        'recipe_contact_phone_number' => 'Contact person phone is required',
        'recipe_contact_mail'         => 'Contact person email is required',
        'recipe_contact_address'      => 'Recipient address is required',
    ],
    'cloud' => [
        'link' => 'Or provide file sharing link.',
        'description' => '(If file\'s size is more than 2MB or provide more than two files.)',
        'error' => 'Either file or link.',
        'only_url' => 'Please provide sharing link.'
    ]
];
