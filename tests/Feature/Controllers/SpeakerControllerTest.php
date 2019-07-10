<?php

namespace Tests\Feature;

use App\Speaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class SpeakerControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    use WithoutMiddleware;

    public function testIndex()
    {
        $response = $this->json('GET', '/api/speaker');

        $response->assertJson([
            'data' => [
                'current_page' => 1,
            ]
        ]);
    }

    public function testApiGetSpeaker()
    {
        $testID = 1;
        $response = $this->json('GET', "/api/speaker/{$testID}");

        $response->assertJson([
            'data' => [
                'id' => $testID
            ],
        ]);
    }

    public function testApiCreateSpeaker()
    {
        $name = $this->faker->name;
        $response = $this->json(
            'POST',
            '/api/speaker',
            ['name' => $name]
        );

        $response->assertJson([
            'data' => [
                'name' => $name,
            ]
        ]);
    }

    public function testApiUpdateSpeaker()
    {
        $name_e = $this->faker->name;
        $speaker = factory(Speaker::class, 1)->create()->first();
        $response = $this->json(
            'PUT',
            "/api/speaker/{$speaker->id}",
            [
                'name' => $speaker->name,
                'name_e' => $name_e,
            ]
        );



        $response->assertJson([
            'data' => [
                'name_e' => $name_e,
            ]
        ]);
    }

    public function testApiDeleteSpeaker()
    {
        $speaker = factory(Speaker::class, 1)->create()->first();
        $response = $this->json('DELETE', "/api/speaker/{$speaker->id}");

        $response->assertJson([
            'message' => 'destroy success.',
        ]);
    }


    public function testExternalUpdateSpeaker()
    {
        $name_e = $this->faker->name;
        $speaker = factory(Speaker::class, 1)->create()->first();
        $response = $this->json(
            'PUT',
            "/speaker/{$speaker->access_key}",
            [
                'name' => $speaker->name,
                'name_e' => $name_e,
                'password' => $speaker->access_secret,
            ]
        );

        $response->assertJson([
            'data' => [
                'name_e' => $name_e,
            ]
        ]);
    }

    public function testExportSpeakers()
    {
        $speakers = factory(Speaker::class, 5)->create();
        $ids = $speakers->map(function ($item) {
            return $item->id;
        });
        $response = $this->get('/api/speaker/export?ids=' . implode(',', $ids->all()));

        $response->assertSuccessful();
    }
}
