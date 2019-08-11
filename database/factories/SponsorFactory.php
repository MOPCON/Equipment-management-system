<?php

use App\Sponsor;

$factory->define(App\Sponsor::class, function () {
    $enFaker = Faker\Factory::create();
    $zhFaker = Faker\Factory::create('zh_TW');

    return [
        'sponsor_type'                 => rand(0, count(Sponsor::$sponsorTypeItem) - 1),
        'sponsor_status'               => rand(0, count(Sponsor::$sponsorStatusItem) - 1),
        'name'                         => $zhFaker->company,
        'en_name'                      => $enFaker->company,
        'introduction'                 => $zhFaker->text(120),
        'en_introduction'              => $enFaker->text(120),
        'website'                      => $enFaker->url,
        'social_media'                 => $enFaker->url,
        'production'                   => $zhFaker->text(120),
        'logo_path'                    => $enFaker->imageUrl(120, 120, 'cats'),
        'service_photo_path'           => $enFaker->imageUrl(120, 120, 'cats'),
        'promote'                      => $zhFaker->text(80),
        'slide_path'                   => $enFaker->imageUrl(120, 120, 'cats'),
        'board_path'                   => $enFaker->imageUrl(120, 120, 'cats'),
        'opening_remarks'              => $zhFaker->text(120),
        'recipe_full_name'             => $zhFaker->company,
        'recipe_tax_id_number'         => $zhFaker->VAT,
        'recipe_amount'                => $zhFaker->numberBetween(10000, 1000000),
        'recipe_contact_name'          => $zhFaker->name,
        'recipe_contact_title'         => $zhFaker->jobTitle,
        'recipe_contact_phone'         => $zhFaker->phoneNumber,
        'recipe_contact_email'         => $zhFaker->email,
        'recipe_contact_address'       => $zhFaker->address,
        'reason'                       => $zhFaker->text(120),
        'purpose'                      => $zhFaker->text(120),
        'remark'                       => $zhFaker->text(120),
        'advence_icck_ad_path'         => $enFaker->imageUrl(120, 120, 'cats'),
        'advence_registration_ad_path' => $enFaker->imageUrl(120, 120, 'cats'),
        'advence_keynote'              => $zhFaker->text(120),
        'advence_hall_flag_path'       => $enFaker->imageUrl(120, 120, 'cats'),
        'advence_main_flow_flag_path'  => $enFaker->imageUrl(120, 120, 'cats'),
        'note'                         => $zhFaker->text(50),
        'updated_by'                   => 0,
    ];
});
