<?php

namespace Tests\Feature;

use App\User;
use App\Sponsor;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
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
        $recipe_amount = $sponsor->recipe_amount;

        $new_company_name = $this->faker->company;
        $new_recipe_amount = $recipe_amount + 10;

        $response = $this->json('PUT', '/sponsor/' . $access_key, [
            'password' => $password,
            'name' => $new_company_name,
            'recipe_full_name' => $new_company_name,
            'recipe_amount' => $new_recipe_amount
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'main' => [
                        'name' => $new_company_name,
                    ],
                    'recipe' => [
                        'recipe_full_name' => $new_company_name,
                        'recipe_amount' => $recipe_amount,
                    ],
                    'advence' => [],
                ]
            ]);
    }

    public function testExternalUpdateSponsorUploadImage()
    {
        $sponsor = factory(Sponsor::class, 1)->create()->first();
        $access_key = $sponsor->access_key;
        $password = $sponsor->access_secret;

        $name = $this->faker->company;
        $contact = $this->faker->name;
        $logo = $this->faker->image('/tmp', 100, 100);
        $logo_path = pathinfo($logo, PATHINFO_BASENAME);
        $ext = mime_content_type($logo);
        $file = new UploadedFile($logo, $logo_path, $ext, null, true);

        $response = $this->post('/sponsor/' . $access_key, [
            '_method' => 'PUT',
            'password' => $password,
            'name' => $name,
            'recipe_contact_name' => $contact,
            'logo_path' => $file,
        ]);

        $new_path = json_decode($response->getContent(), true)['data']['main']['logo_path'];
        $new_path_info = explode('/', $new_path);
        $new_file_name = end($new_path_info);
        $this->assertFileExists(public_path(Sponsor::$filePath) . '/' .$new_file_name);
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Update success.',
                'data' => [
                    'main' => [
                        'name' => $name,
                    ],
                    'recipe' => [
                        'recipe_contact_name' =>$contact,
                    ]
                ]
            ]);
        @unlink(public_path() . '/' .$new_path);
    }

    public function testExternalUpdateSponsorUploadIllegalFile()
    {
        $sponsor = factory(Sponsor::class, 1)->create()->first();
        $access_key = $sponsor->access_key;
        $password = $sponsor->access_secret;

        $name = $this->faker->company;
        $contact = $this->faker->name;
        $file = $file = UploadedFile::fake()->create('document.doc', 100);

        $response = $this->post('/sponsor/' . $access_key, [
            '_method' => 'PUT',
            'password' => $password,
            'name' => $name,
            'recipe_contact_name' => $contact,
            'logo_path' => $file,
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'The logo path must be a file of type: jpeg, png, gif, bmp, svg, pdf, ai, eps, psd, zip, rar.',
            ]);
    }

    public function testExternalUpdateSponsorWithWrongAccessKey()
    {
        $sponsor = factory(Sponsor::class, 1)->create()->first();
        $access_key = strrev($sponsor->access_key);
        $password = $sponsor->access_secret;

        $new_company_name = $this->faker->company;

        $response = $this->json('PUT', '/sponsor/' . $access_key, [
            'password' => $password,
            'name' => $new_company_name,
            'recipe_full_name' => $new_company_name
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

        $new_company_name = $this->faker->company;

        $response = $this->json('PUT', '/sponsor/' . $access_key, [
            'password' => $password,
            'name' => $new_company_name,
            'recipe_full_name' => $new_company_name
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
        $recipe_amount = $this->faker->numberBetween(88888, 8888888);
        $response = $this->json('POST', '/api/sponsor', [
            'name' => $company,
            'recipe_amount' => $recipe_amount,
            'sponsor_type' => $sponsorType,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => $company,
                    'sponsor_type' => $sponsorType,
                    'recipe_amount' => $recipe_amount,
                    'sponsor_status' => 0,
                ]
            ]);
    }

    public function testApiCreateSponsorWithNoName()
    {
        $user = User::find(1);
        $sponsorType = rand(0, count(Sponsor::$sponsorTypeItem) - 1);
        $this->actingAs($user);
        $recipe_amount = $this->faker->numberBetween(88888, 8888888);
        $response = $this->json('POST', '/api/sponsor', [
            'sponsor_type' => $sponsorType,
            'recipe_amount' => $recipe_amount,
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'message' => '【name】必填'
            ]);
    }

    public function testApiCreateSponsorWithNoRecipeAmount()
    {
        $user = User::find(1);
        $sponsorType = rand(0, count(Sponsor::$sponsorTypeItem) - 1);
        $this->actingAs($user);
        $company = $this->faker->company;
        $recipe_amount = $this->faker->numberBetween(88888, 8888888);
        $response = $this->json('POST', '/api/sponsor', [
            'name' => $company,
            'sponsor_type' => $sponsorType,
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'message' => '請填寫贊助金額',
            ]);
    }

    public function testGetSponsorList()
    {
        $response = $this->get('/api/sponsor');

        $response->assertStatus(200);
    }

    public function testGetSponsorListWithfilterAll()
    {
        $sponsor = factory(Sponsor::class, 1)->create()->first();
        $filter = json_encode([
            'status' => $sponsor->sponsor_status,
            'type' => $sponsor->sponsor_type,
        ]);
        
        $response = $this->get('/api/sponsor', [
            'filter' => $filter
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'data' => [
                        [
                            'sponsor_status' => $sponsor->sponsor_status,
                            'sponsor_type' => $sponsor->sponsor_type,
                        ]
                    ]
                ]
            ]);
    }

    public function testGetSponsorListWithfilterStatus()
    {
        $sponsor = factory(Sponsor::class, 1)->create()->first();
        $filter = json_encode([
            'status' => $sponsor->sponsor_status,
        ]);

        $response = $this->get('/api/sponsor', [
            'filter' => $filter
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'data' => [
                        [
                            'sponsor_status' => $sponsor->sponsor_status,
                        ]
                    ]
                ]
            ]);
    }

    public function testGetSponsorListWithfilterType()
    {
        $sponsor = factory(Sponsor::class, 1)->create()->first();
        $filter = json_encode([
            'type' => $sponsor->sponsor_type,
        ]);

        $response = $this->get('/api/sponsor', [
            'filter' => $filter
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'data' => [
                        [
                            'sponsor_type' => $sponsor->sponsor_type,
                        ]
                    ]
                ]
            ]);
    }

    public function testGetSponsorListWithSearchName()
    {
        $sponsor = factory(Sponsor::class, 1)->create()->first();
        $search = $sponsor->name;

        $response = $this->get('/api/sponsor', [
            'search' => $search
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'data' => [
                        [
                            'name' => $search,
                        ]
                    ]
                ]
            ]);
    }

    public function testGetSponsorListWithSearchContact()
    {
        $sponsor = factory(Sponsor::class, 1)->create()->first();
        $search = $sponsor->recipe_contact_name;

        $response = $this->get('/api/sponsor', [
            'search' => $search
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'data' => [
                        [
                            'recipe_contact_name' => $search,
                        ]
                    ]
                ]
            ]);
    }

    public function testGetSponsorListWithSearchAndFilter()
    {
        $sponsor = factory(Sponsor::class, 1)->create()->first();
        $search = $sponsor->recipe_contact_name;
        $filter = json_encode([
            'status' => $sponsor->sponsor_status,
            'type' => $sponsor->sponsor_type,
        ]);

        $response = $this->get('/api/sponsor', [
            'search' => $search,
            'filter' => $filter
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'data' => [
                        [
                            'recipe_contact_name' => $search,
                            'sponsor_status' => $sponsor->sponsor_status,
                            'sponsor_type' => $sponsor->sponsor_type,
                        ]
                    ]
                ]
            ]);
    }

    public function testUpdateSponsor()
    {
        $sponsor = factory(Sponsor::class, 1)->create()->first();
        $name= $this->faker->company;
        $contact = $this->faker->name;
        $recipe_amount = $sponsor->recipe_amount;

        $new_recipe_amount = $recipe_amount + 1000;

        $response = $this->json('PUT', '/api/sponsor/' . $sponsor->id, [
            'name' => $name,
            'recipe_contact_name' => $contact,
            'recipe_amount' => $new_recipe_amount,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'main' => [
                        'name' => $name,
                    ],
                    'recipe' => [
                        'recipe_contact_name' =>$contact,
                        'recipe_amount' => $new_recipe_amount,
                    ]
                ]
            ]);
    }

    public function testDeleteSponsor()
    {
        $sponsor = factory(Sponsor::class, 1)->create()->first();
        $response = $this->json('DELETE', "/api/sponsor/" . $sponsor->id);
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'destroy success.',
            ]);
    }

    public function testExportSponsor()
    {
        $sponsor = factory(Sponsor::class, 5)->create();
        $ids = $sponsor->map(function ($item) {
            return $item->id;
        });
        $response = $this->get('/api/sponsor/export?ids=' . implode(',', $ids->all()));

        $response->assertSuccessful()
            ->assertHeader('Content-Type', 'text/tab-separated-values; charset=UTF-8');
    }

    public function testUpdateSponsorUploadImage()
    {
        $sponsor = factory(Sponsor::class, 1)->create()->first();
        $name = $this->faker->company;
        $contact = $this->faker->name;
        $logo = $this->faker->image('/tmp', 100, 100);
        $logo_path = pathinfo($logo, PATHINFO_BASENAME);
        $ext = mime_content_type($logo);
        $file = new UploadedFile($logo, $logo_path, $ext, null, true);

        $response = $this->post('/api/sponsor/' . $sponsor->id, [
            '_method' => 'PUT',
            'name' => $name,
            'recipe_contact_name' => $contact,
            'logo_path' => $file,
        ]);

        $new_path = json_decode($response->getContent(), true)['data']['main']['logo_path'];
        $new_path_info = explode('/', $new_path);
        $new_file_name = end($new_path_info);
        $this->assertFileExists(public_path(Sponsor::$filePath) . '/' .$new_file_name);
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Update success.',
                'data' => [
                    'main' => [
                        'name' => $name,
                    ],
                    'recipe' => [
                        'recipe_contact_name' =>$contact,
                    ]
                ]
            ]);
        @unlink(public_path() . '/' .$new_path);
    }

    public function testUpdateSponsorUploadIllegalFile()
    {
        $sponsor = factory(Sponsor::class, 1)->create()->first();
        $name = $this->faker->company;
        $contact = $this->faker->name;
        $file = UploadedFile::fake()->create('document.doc', 100);

        $response = $this->post('/api/sponsor/' . $sponsor->id, [
            '_method' => 'PUT',
            'name' => $name,
            'recipe_contact_name' => $contact,
            'logo_path' => $file,
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'The logo path must be a file of type: jpeg, png, gif, bmp, svg, pdf, ai, eps, psd, zip, rar.',
            ]);
    }
}
