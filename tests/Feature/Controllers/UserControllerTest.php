<?php

namespace Tests\Feature\Controllers;

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use WithoutMiddleware;

    public function testUpdateUser()
    {
        /** arrange */
        $user = User::factory()->create();
        $newName = 'Test';
        $newMail = 'Test@gmail.com';

        /** Act */
        $response = $this->putJson("/api/user/{$user->id}", [
            'name' => $newName,
            'email' => $newMail,
            'roles' => ['admin']
        ]);

        /** Assert */
        $response->assertOk();
        $this->assertDatabaseHas('model_has_roles', ['role_id' => 1, 'model_id' => $user->id]);
    }
}
