<?php

namespace Tests\Utils;

use App\User;
use Laravel\Lumen\Testing\DatabaseMigrations;

trait CreatesUser
{
    use DatabaseMigrations;

    /**
     * Create a test user
     *
     * @return void
     */
    protected function createUser()
    {
        $this->artisan('make:admin', [
            'email' => $this->userEmail(),
            'password' => $this->userPassword()
        ]);
    }

    /**
     * Get the email of the created user
     *
     * @return string
     */
    protected function userEmail()
    {
        return 'test@example.com';
    }

    /**
     * Get the raw password string of the created user
     *
     * @return string
     */
    protected function userPassword()
    {
        return 'password';
    }

    /**
     * Get an instance of the created user
     *
     * @return \App\User
     */
    protected function user()
    {
        return User::firstWhere('email', $this->userEmail());
    }
}
