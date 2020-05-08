<?php

use Laravel\Lumen\Testing\DatabaseMigrations;

class ReportEndpointTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');
    }

    public function testListEndpoint()
    {
        $uri = route('api.reports.list');

        $res = $this->get($uri);

        $res->assertResponseStatus(200);

        $res->seeJsonStructure([
            'data',
            'meta',
        ]);
    }
}
