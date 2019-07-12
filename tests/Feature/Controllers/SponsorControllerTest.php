<?php

namespace Tests\Feature;

use App\User;
use App\Sponsor;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class SponsorControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    use WithoutMiddleware;

    public function testGetOptions()
    {
        $response = $this->get('/sponsor/get-options');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'sponsorStatusItem' => [],
                    'sponsorTypeItem' => [],
                ]
            ]);
    }

    public function testExternalPageShow()
    {
        $sponsor = factory(Sponsor::class, 1)->create()->first();
        $access_key = $sponsor->access_key;

        $response = $this->get('/sponsor/form/' . $access_key);

        $response->assertStatus(200);
    }

    public function testExternalPageShowWithWrongAccessKey()
    {
        $sponsor = factory(Sponsor::class, 1)->create()->first();
        $access_key = strrev($sponsor->access_key);

        $response = $this->get('/sponsor/form/' . $access_key);

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Not found'
            ]);
    }

    public function testExternalGetSponsor()
    {
        $sponsor = factory(Sponsor::class, 1)->create()->first();
        $access_key = $sponsor->access_key;
        $password = $sponsor->access_secret;

        $response = $this->json('POST', '/sponsor/' . $access_key, [
            'password' => $password,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'main' => [
                        'name' => $sponsor->name,
                    ],
                    'recipe' => [],
                    'advence' => [],
                ]
            ]);
    }

    public function testExternalGetSponsorWithWrongAccessKey()
    {
        $sponsor = factory(Sponsor::class, 1)->create()->first();
        $access_key = strrev($sponsor->access_key);
        $password = $sponsor->access_secret;

        $response = $this->json('POST', '/sponsor/' . $access_key, [
            'password' => $password,
        ]);

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Not found'
            ]);
    }
    
    public function testExternalGetSponsorWithWrongPassword()
    {
        $sponsor = factory(Sponsor::class, 1)->create()->first();
        $access_key = $sponsor->access_key;
        $password = strrev($sponsor->access_secret);

        $response = $this->json('POST', '/sponsor/' . $access_key, [
            'password' => $password,
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'message' => '密碼錯誤'
            ]);
    }

    public function testExternalUpdateSponsor()
    {
        $sponsor = factory(Sponsor::class, 1)->create()->first();
        $access_key = $sponsor->access_key;
        $password = $sponsor->access_secret;

        $newCompanyName = $this->faker->company;

        $response = $this->json('PUT', '/sponsor/' . $access_key, [
            'password' => $password,
            'name' => $newCompanyName,
            'recipe_full_name' => $newCompanyName
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'main' => [
                        'name' => $newCompanyName,
                    ],
                    'recipe' => [
                        'recipe_full_name' => $newCompanyName,
                    ],
                    'advence' => [],
                ]
            ]);
    }

    public function testExternalUpdateSponsorWithWrongAccessKey()
    {
        $sponsor = factory(Sponsor::class, 1)->create()->first();
        $access_key = strrev($sponsor->access_key);
        $password = $sponsor->access_secret;

        $newCompanyName = $this->faker->company;

        $response = $this->json('PUT', '/sponsor/' . $access_key, [
            'password' => $password,
            'name' => $newCompanyName,
            'recipe_full_name' => $newCompanyName
        ]);
        
        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Not found'
            ]);
    }

    public function testExternalUpdateSponsorWithWrongPassword()
    {
        $sponsor = factory(Sponsor::class, 1)->create()->first();
        $access_key = $sponsor->access_key;
        $password = strrev($sponsor->access_secret);

        $newCompanyName = $this->faker->company;

        $response = $this->json('PUT', '/sponsor/' . $access_key, [
            'password' => $password,
            'name' => $newCompanyName,
            'recipe_full_name' => $newCompanyName
        ]);
        
        $response->assertStatus(400)
            ->assertJson([
                'message' => '密碼錯誤'
            ]);
    }

    public function testApiCreateSponsor()
    {
        $user = User::find(1);
        $sponsorType = rand(0, count(Sponsor::$sponsorTypeItem) - 1);
        $this->actingAs($user);
        $company = $this->faker->company;
        $response = $this->json('POST', '/api/sponsor', [
            'name' => $company,
            'sponsor_type' => $sponsorType,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => $company,
                    'sponsor_type' => $sponsorType,
                    'sponsor_status' => 0,
                ]
            ]);
    }

    public function testApiCreateSponsorWithNoName()
    {
        $user = User::find(1);
        $sponsorType = rand(0, count(Sponsor::$sponsorTypeItem) - 1);
        $this->actingAs($user);
        $response = $this->json('POST', '/api/sponsor', [
            'sponsor_type' => $sponsorType,
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'message' => '【name】必填'
            ]);
    }

    public function testGetSponsorList()
    {
        $response = $this->get('/api/sponsor');

        $response->assertStatus(200);
    }
}
