<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use WithoutMiddleware;

    public function testChangePassword_測試正常更新密碼()
    {
        /** arrange */
        $user = User::factory()->create();
        $user->password = Hash::make('P@$$word');
        $user->save();
        Auth::login($user);

        /** Act */
        $response = $this->postJson("/api/auth/change-password", [
            'old_password'          => 'P@$$word',
            'password'              => '1234567890',
            'password_confirmation' => '1234567890',
        ]);

        /** Assert */
        $user->refresh();
        $response->assertOk();
        $this->assertFalse(Hash::check('P@$$word', $user->password));
        $this->assertTrue(Hash::check('1234567890', $user->password));
    }

    public function testChangePassword_測試舊密碼錯誤()
    {
        /** arrange */
        $user = User::factory()->create();
        $user->password = Hash::make('P@$$word');
        $user->save();
        Auth::login($user);

        /** Act */
        $response = $this->postJson("/api/auth/change-password", [
            'old_password'          => 'P@$$word_OAO',
            'password'              => '1234567890',
            'password_confirmation' => '1234567890',
        ]);
        $result = $this->getApiResult($response);

        /** Assert */
        $user->refresh();
        $response->assertStatus(400);
        $this->assertEquals('密碼錯誤', $result['message']);
        $this->assertTrue(Hash::check('P@$$word', $user->password));
        $this->assertFalse(Hash::check('1234567890', $user->password));
    }

    public function testChangePassword_測試新密碼確認錯誤()
    {
        /** arrange */
        $user = User::factory()->create();
        $user->password = Hash::make('P@$$word');
        $user->save();
        Auth::login($user);

        /** Act */
        $response = $this->postJson("/api/auth/change-password", [
            'old_password'          => 'P@$$word',
            'password'              => '1234567890',
            'password_confirmation' => '1234567890_OAO',
        ]);
        $result = $this->getApiResult($response);

        /** Assert */
        $user->refresh();
        $response->assertStatus(400);
        $this->assertEquals('【新密碼】與【確認新密碼】不同。', $result['message']);
        $this->assertTrue(Hash::check('P@$$word', $user->password));
        $this->assertFalse(Hash::check('1234567890', $user->password));
    }

    public function testChangePassword_測試缺少新密碼()
    {
        /** arrange */
        $user = User::factory()->create();
        $user->password = Hash::make('P@$$word');
        $user->save();
        Auth::login($user);

        /** Act */
        $response = $this->postJson("/api/auth/change-password", [
            'old_password'          => 'P@$$word',
            'password_confirmation' => '1234567890_OAO',
        ]);
        $result = $this->getApiResult($response);

        /** Assert */
        $user->refresh();
        $response->assertStatus(400);
        $this->assertEquals('【新密碼】必填', $result['message']);
        $this->assertTrue(Hash::check('P@$$word', $user->password));
        $this->assertFalse(Hash::check('1234567890', $user->password));
    }

    public function testChangePassword_測試缺少舊密碼()
    {
        /** arrange */
        $user = User::factory()->create();
        $user->password = Hash::make('P@$$word');
        $user->save();
        Auth::login($user);

        /** Act */
        $response = $this->postJson("/api/auth/change-password", [
            'assword'          => 'P@1234567890',
            'password_confirmation' => '1234567890',
        ]);
        $result = $this->getApiResult($response);

        /** Assert */
        $user->refresh();
        $response->assertStatus(400);
        $this->assertEquals('【舊密碼】必填', $result['message']);
        $this->assertTrue(Hash::check('P@$$word', $user->password));
        $this->assertFalse(Hash::check('1234567890', $user->password));
    }
}
