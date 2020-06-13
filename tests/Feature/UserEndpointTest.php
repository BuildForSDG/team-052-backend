<?php

namespace Tests\Feature;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Utils\CreatesUser;

class UserEndpointTest extends TestCase
{
    use DatabaseMigrations, CreatesUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createUser();

        $this->artisan('db:seed');
    }

    public function testAdmin_Can_CreateOtherAdmins()
    {
        $uri = route('api.users.store');

        $name = 'Victor';
        $email = 'email@email.com';
        $password = 'easypass';
        $admin_role = 'responder';

        $res = $this->actingAs($this->user())->post($uri, compact('name', 'email', 'password', 'admin_role'));

        $this->assertResponseStatus(201);

        $this->seeInDatabase('users', [
            'name' => $name,
            'email' => $email,
            'admin_role' => $admin_role
        ]);
    }

    public function testResponder_Cannot_CreateAdmin()
    {
        $uri = route('api.users.store');

        $user = $this->user();
        $user->admin_role = 'responder';
        $user->save();

        $res = $this->actingAs($user)->post($uri);

        $this->assertResponseStatus(403);
    }

    public function testCreateEndpoint_With_InvalidData()
    {
        $uri = route('api.users.store');

        $res = $this->actingAs($this->user())->post($uri, [
            'admin_role' => 'fake_role'
        ]);

        $this->assertResponseStatus(422);
    }
}
