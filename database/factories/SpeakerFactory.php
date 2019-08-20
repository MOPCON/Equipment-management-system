<?php

use App\Speaker;

$factory->define(Speaker::class, function (Faker\Generator $faker) {
    $zhFaker = Faker\Factory::create('zh_TW');

    $tags = $faker->randomElements(array_keys(Speaker::$tagItem), $faker->numberBetween(0, count(Speaker::$tagItem) - 1));
    sort($tags);

    return [
        'name' => $zhFaker->name,
        'name_e' => $faker->name,
        'company' => $zhFaker->company,
        'company_e' => $faker->company,
        'job_title' => $zhFaker->jobTitle,
        'job_title_e' => $faker->jobTitle,
        'bio' => $zhFaker->text(120),
        'bio_e' => $faker->text(240),
        'photo' => 'https://picsum.photos/500',
        'link_fb' => $faker->url,
        'link_github' => $faker->url,
        'link_twitter' => $faker->url,
        'link_other' => $faker->url,
        'topic' => $zhFaker->text(16),
        'topic_e' => $faker->text(32),
        'summary' => $zhFaker->text(240),
        'summary_e' => $faker->text(480),
        'tag' => $tags,
        'level' => rand(0, count(Speaker::$levelItem) - 1),
        'license' => rand(0, count(Speaker::$licenseItem) - 1),
        'promotion' => rand(0, 1),
        'tshirt_size' => rand(0, count(Speaker::$tshirtSizeItem) - 1),
        'need_parking_space' => rand(0, 1),
        'has_dinner' => rand(0, 1),
        'meal_preference' => rand(0, count(Speaker::$mealPreferenceItem) - 1),
        'has_companion' => rand(0, 10),
        'speaker_status' => rand(0, count(Speaker::$speakerStatusItem) - 1),
        'speaker_type' => rand(0, count(Speaker::$speakerTypeItem) - 1),
        'is_keynote' => $faker->boolean(33),
        'note' => $zhFaker->text(),
    ];
});
