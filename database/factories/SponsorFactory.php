<?php

namespace Database\Factories;

use App\Sponsor;
use Illuminate\Database\Eloquent\Factories\Factory;

class SponsorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sponsor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $zhFaker = \Faker\Factory::create('zh_TW');

        return [
            'year'                         => $zhFaker->year(),
            'sponsor_type'                 => rand(0, count(Sponsor::$sponsorTypeItem) - 1),
            'sponsor_status'               => rand(0, count(Sponsor::$sponsorStatusItem) - 1),
            'name'                         => $zhFaker->company,
            'en_name'                      => $this->faker->company,
            'introduction'                 => $zhFaker->text(250),
            'en_introduction'              => $this->faker->text(250),
            'website'                      => $this->faker->url,
            'social_media'                 => $this->faker->url,
            'production'                   => $zhFaker->text(250),
            'logo_path'                    => $this->faker->imageUrl(120, 120, 'cats'),
            'service_photo_path'           => $this->faker->imageUrl(120, 120, 'cats'),
            'promote'                      => $zhFaker->text(80),
            'slide_path'                   => $this->faker->imageUrl(120, 120, 'cats'),
            'board_path'                   => $this->faker->imageUrl(120, 120, 'cats'),
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
            'advence_icck_ad_path'         => $this->faker->imageUrl(120, 120, 'cats'),
            'advence_registration_ad_path' => $this->faker->imageUrl(120, 120, 'cats'),
            'advence_keynote'              => $zhFaker->text(120),
            'advence_hall_flag_path'       => $this->faker->imageUrl(120, 120, 'cats'),
            'advence_main_flow_flag_path'  => $this->faker->imageUrl(120, 120, 'cats'),
            'note'                         => $zhFaker->text(50),
            'updated_by'                   => 0,
        ];
    }
}
