<?php

namespace Tests\Feature;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReportEndpointTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware();

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
