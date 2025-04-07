<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected Role $role;

    protected function setUp(): void
    {
        parent::setUp();

        // setup reusable role
        $this->role = $this->createRole();
    }

    /**
     * create a role.
     */
    protected function createRole(array $attributes = []): Role
    {
        return Role::create(array_merge([
            'name' => 'user',
            'description' => 'user description',
            'level' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ], $attributes));
    }

    /**
     * create a user.
     */
    protected function createUser(array $attributes = []): User
    {
        return User::factory()->create(array_merge([
            'role_id' => $this->role->id,
        ], $attributes));
    }

    public function test_user_belongs_to_a_role()
    {
        $user = $this->createUser();

        // access the role relationship
        $userRole = $user->role;

        // assert
        $this->assertInstanceOf(Role::class, $userRole);
        $this->assertEquals($this->role->id, $userRole->id);
    }

    public function test_user_has_clients()
    {
        $user = $this->createUser();

        // create a client associated with the user
        $client = Company::create([
            'name' => 'Fake Company',
            'primary_contact_name' => 'Primary Contact',
            'primary_contact_email' => 'primary@contact.com',
            'primary_contact_phone' => '000-000-0000',
            'address' => '123 Fake Street, Fake City, Fake State 12345',
            'account_manager_id' => $user->id,
        ]);

        // clients relationship
        $userClients = $user->clients;

        // assert
        $this->assertCount(1, $userClients);
        $this->assertTrue($userClients->contains($client));
    }
}
