<?php

use App\User;

class UserTest extends ModelTestCase
{
    protected function requiredColumns(): array
    {
        return [
            'id',
            'name',
            'email',
            'password',
            'admin_role',
            'api_token',
            'created_at',
            'updated_at',
        ];
    }

    public function testShould_CreateAnItem_Successfully()
    {
        factory(User::class)->state('isResponder')->create([
            'name' =>  'damilola'
        ]);

        $this->seeInDatabase($this->databaseTableName(), [
            'name' => 'damilola',
            'admin_role' => 'responder'
        ]);
    }

    public function testShould_SetDefaultRole_To_Null()
    {
        factory(User::class)->create([
            'name' => 'tina'
        ]);

        $this->seeInDatabase($this->databaseTableName(), [
            'name' => 'tina',
            'admin_role' => null
        ]);
    }
}
