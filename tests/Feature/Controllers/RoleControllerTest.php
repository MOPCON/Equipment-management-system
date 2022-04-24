<?php

namespace Tests\Feature;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class RoleControllerTest extends TestCase
{
    use WithoutMiddleware;

    public function testGetRoles()
    {
        /** arrange */
        $role = Role::factory()->create();

        /** Act */
        $response = $this->getJson('/api/role');
        $result = $response->getOriginalContent()['data'];

        /** Assert */
        $response->assertOk();
        $this->assertEquals('admin', $result[0]->name);
        $this->assertEquals($role->name, $result[1]->name);
    }

    public function testShowRoles()
    {
        /** arrange */
        $role = Role::factory()->create();
        $role->syncPermissions(Permission::find(1));


        /** Act */
        $response = $this->getJson("/api/role/{$role->id}");
        $result = $response->getOriginalContent()['data'];

        /** Assert */
        $response->assertOk();
        $this->assertEquals($role->name, $result->name);
        $this->assertEquals($role->permissions[0]->name, $result->permissions[0]->name);
    }

    public function testStoreRoles()
    {
        /** arrange */
        $role = Role::factory()->make();
        $permission = Permission::find(1);

        /** Act */
        $response = $this->postJson('/api/role', [
            'name' => $role->name,
            'permissions' => [$permission->name]
        ]);

        /** Assert */
        $role = Role::findByName($role->name);
        $response->assertOk();
        $this->assertDatabaseHas('roles', ['name' => $role->name]);
        $this->assertDatabaseHas('role_has_permissions', [
            'permission_id' => 1,
            'role_id' => $role->id,
        ]);
    }

    /**
     * 測試新增 Role 時名稱已經存在
     */
    public function testStoreRoleNameExist()
    {
        /** arrange */
        $role = Role::factory()->create();

        /** Act */
        $response = $this->postJson('/api/role', [
            'name' => $role->name,
            'permissions' => []
        ]);

        /** Assert */
        $response->assertStatus(400);
        $this->assertEquals($response->getOriginalContent()['message'], 'The 名稱 has already been taken.');
    }

    public function testUpdateRole()
    {
        /** arrange */
        $role = Role::factory()->create();
        $newName = 'Test';

        /** Act */
        $response = $this->putJson("/api/role/{$role->id}", [
            'name' => $newName,
            'permissions' => []
        ]);

        /** Assert */
        $response->assertOk();
        $this->assertDatabaseHas('roles', ['name' => $newName]);
    }

    /**
     * 測試更新 Role 時名稱已經存在
     */
    public function testUpdateRoleNameExist()
    {
        /** arrange */
        $role = Role::factory()->create();
        $newName = 'admin';

        /** Act */
        $response = $this->putJson("/api/role/{$role->id}", [
            'name' => $newName,
            'permissions' => []
        ]);

        /** Assert */
        $response->assertStatus(400);
        $this->assertEquals($response->getOriginalContent()['message'], 'The 名稱 has already been taken.');
    }

    public function testDestroyRole()
    {
        /** arrange */
        $role = Role::factory()->create();

        /** Act */
        $response = $this->deleteJson("/api/role/{$role->id}");

        /** Assert */
        $response->assertOk();
        $this->assertDatabaseMissing('roles', ['name' => $role->name]);
    }
}
