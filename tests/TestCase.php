<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Facades\Auth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // 產生資料庫資料
        $this->seed();

        // 指派執行的 User
        Auth::login(User::find(1));
    }

    /**
     * @param TestResponse $response
     * @return array @see {@link App\Http\Controllers\ApiTrait}
     */
    protected function getApiResult(TestResponse $response): array
    {
        return json_decode($response->getContent(), true);
    }
}
