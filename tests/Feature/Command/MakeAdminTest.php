<?php

namespace Tests\Feature\Command;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class MakeAdminTest extends TestCase
{
    use DatabaseMigrations;

    public function testCommand_Should_CreateAdmin()
    {
        $this->artisan('make:admin');

        $this->seeInDatabase('users', ['email' => 'admin@example.com', 'admin_role' => 'superadmin']);
    }

    public function testCommand_Should_CreateAdmin_With_Values()
    {
        $email = 'custom@mydomain.com';

        $this->artisan('make:admin', [
            'email' =>  $email
        ]);

        $this->seeInDatabase('users', ['email' => $email]);
    }
}
