<?php

namespace Tests\Feature;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Utils\CreatesUser;

class AuthenticationTest extends TestCase
{
    use DatabaseMigrations, CreatesUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createUser();

        $this->artisan('db:seed');
    }

    public function testUserCanLogin()
    {
        $res = $this->login();

        $res->assertResponseStatus(200);

        $res->seeJsonStructure([
            'message',
            'data' => [
                'api_token'
            ]
        ]);
    }

    public function testAuth_ShouldFail_With_WrongCredentials()
    {
        $res = $this->login([
            'email' => 'wrongemail@dx.com',
            'password' => 'wrongtoo'
        ]);

        $res->assertResponseStatus(422);

        $res->seeJsonStructure([
            'message',
            'errors' => [
                'email'
            ],
        ]);
    }

    public function testUnAuthUser_ShouldNot_View_ProtectedRoute()
    {
        $uri = route('api.reports.list');

        $res = $this->get($uri);

        $res->assertResponseStatus(401);
    }

    public function testAuthUser_Should_View_ProtectedRoute()
    {
        $uri = route('api.reports.list');

        $res = $this->actingAs($this->user())->get($uri);

        $res->assertResponseStatus(200);
    }

    public function testUserCanLogin_And_ViewProtectedRoute_WithBearerToken()
    {
        $res = $this->login();

        $res->assertResponseStatus(200);

        $data = (array) json_decode($res->response->getContent(), true);
        $token = $data['data']['api_token'];

        $this->get(route('api.reports.list'), [
            'Authorization' => "Bearer $token",
        ])->assertResponseStatus(200);
    }

    public function testUserCanLogout()
    {
        $res = $this->logout();

        $res->assertResponseStatus(200);

        $res->seeJson([
            'message' => 'logout successful'
        ]);
    }

    public function testUserCanSeeAuthenticatedUser()
    {
        $login = $this->login();

        $login->assertResponseStatus(200);

        $data = (array) json_decode($login->response->getContent(), true);
        $token = $data['data']['api_token'];

        $res = $this->get(route('api.me'), [
            'Authorization' => "Bearer $token"
        ]);

        $res->assertResponseStatus(200);

        $res->seeJsonEquals([
            'data' => $this->user()
        ]);
    }

    /**
     * Make a logout request
     *
     * @return $this
     */
    protected function logout()
    {
        $this->login()->assertResponseStatus(200);

        return $this->post(route('api.auth.logout'));
    }

    /**
     * Make a login request to the app
     *
     * @param null|array $data
     * @return $this
     */
    protected function login(?array $data = null)
    {
        $data = $data ?? [
            'email' => $this->userEmail(),
            'password' => $this->userPassword()
        ];

        $uri = route('api.auth.login');

        return $this->post($uri, $data);
    }
}
