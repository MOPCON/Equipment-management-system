<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Services\SystemLogService;
use App\SystemLog;

class SystemLogServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testSystemLogService()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $content = 'test' . time();
        (new SystemLogService)->write($content, 1);

        // $this->assertAuthenticatedAs($user);
        $this->assertEquals($content, SystemLog::orderBy('id', 'desc')->first()->content);
    }
}
