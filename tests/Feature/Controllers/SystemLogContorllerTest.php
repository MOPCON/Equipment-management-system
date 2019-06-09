<?php

namespace Tests\Feature;

use App\User;
use App\Services\SystemLogService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class SystemLogContorllerTest extends TestCase
{
    use WithoutMiddleware;

    public function testGetLog()
    {
        $response = $this->json('GET', '/api/system-log');

        $response->assertStatus(200);
    }

    public function testSearchLogWithType()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $content = 'test' . time();
        (new SystemLogService)->write($content, 3);

        $response = $this->json('GET', '/api/system-log', [
            'type_id' => '3',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'data' => [
                        [
                            'type_id' => '3',
                        ]
                    ]
                ]
            ]);
    }

    public function testSearchLogWithName()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $content = 'test' . time();
        (new SystemLogService)->write($content, 2);

        $search = json_encode([
            'username' => 'admin',
        ]);

        $response = $this->json('GET', '/api/system-log', [
            'search' => $search,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'data' => [
                        [
                            'user_name' => 'admin',
                        ]
                    ]
                ]
            ]);
    }

    public function testSearchLogWithContent()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $content = 'test' . time();
        (new SystemLogService)->write($content, 1);

        $search = json_encode([
            'content' => $content
        ]);

        $response = $this->json('GET', '/api/system-log', [
            'search' => $search,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'data' => [
                        [
                            'content' => $content
                        ]
                    ]
                ]
            ]);
    }

    public function testSearchLogWithTypeAndName()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $content = 'test' . time();
        (new SystemLogService)->write($content, 1);

        $search = json_encode([
            'username' => 'admin',
        ]);

        $response = $this->json('GET', '/api/system-log', [
            'type_id' => '1',
            'search'  => $search,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'data' => [
                        [
                            'type_id'   => '1',
                            'user_name' => 'admin',
                        ]
                    ]
                ]
            ]);
    }

    public function testSearchLogWithTypeAndContent()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $content = 'test' . time();
        (new SystemLogService)->write($content, 1);

        $search = json_encode([
            'content' => $content
        ]);

        $response = $this->json('GET', '/api/system-log', [
            'type_id' => '1',
            'search' => $search,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'data' => [
                        [
                            'type_id' => '1',
                            'content' => $content
                        ]
                    ]
                ]
            ]);
    }

    public function testSearchLogWithNameAndContent()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $content = 'test' . time();
        (new SystemLogService)->write($content, 1);

        $search = json_encode([
            'username' => 'admin',
            'content'  => $content
        ]);

        $response = $this->json('GET', '/api/system-log', [
            'search' => $search,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'data' => [
                        [
                            'content'   => $content,
                            'user_name' => 'admin'
                        ]
                    ]
                ]
            ]);
    }

    public function testSearchLogAllCondition()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $content = 'test' . time();
        (new SystemLogService)->write($content, 1);

        $search = json_encode([
            'username' => 'admin',
            'content'  => $content
        ]);

        $response = $this->json('GET', '/api/system-log', [
            'type_id' => '1',
            'search'  => $search,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'data' => [
                        [
                            'type_id'   => '1',
                            'content'   => $content,
                            'user_name' => 'admin',
                        ]
                    ]
                ]
            ]);
    }
}
