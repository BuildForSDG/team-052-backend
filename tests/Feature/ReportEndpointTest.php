<?php

namespace Tests\Feature;

use App\Report;
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

    public function testGuestListEndpoint()
    {
        $uri = route('api.guest.reports');

        $res = $this->get($uri);

        $res->assertResponseStatus(200);

        $res->seeJsonStructure([
            'data',
            'meta',
        ]);
    }

    public function testMetricsEndpoint()
    {
        $uri = route('api.reports.metrics');

        $res = $this->get($uri);

        $res->assertResponseStatus(200);

        $res->seeJsonStructure([
            'reported_cases',
            'pending_cases',
            'enroute_cases',
            'onsite_cases',
            'acknowledged_cases'
        ]);
    }

    public function testGuestMetricsEndpoint()
    {
        $uri = route('api.guest.metrics');

        $res = $this->get($uri);

        $res->assertResponseStatus(200);

        $res->seeJsonStructure([
            'reported_cases',
            'pending_cases',
            'enroute_cases',
            'onsite_cases',
            'acknowledged_cases'
        ]);
    }

    public function testReadEndpoint()
    {
        $uri = route('api.reports.read', [
            'id' => 1
        ]);

        $res = $this->get($uri);

        $res->assertResponseStatus(200);

        $res->seeJsonStructure([
            'data',
        ]);
    }

    public function testUpdateStatusEndpoint()
    {
        $report = Report::find(1);
        $new_status = 'acknowledged';

        $uri = route('api.reports.update', [
            'id' => $report->id
        ]);

        $res = $this->patch($uri, [
            'status' => $new_status
        ]);

        $res->assertResponseStatus(204);

        $report = Report::find(1);

        $this->assertEquals($new_status, $report->status);
    }

    public function testShould_FilterIncidents_By_Status()
    {
        $uri = route('api.reports.list', [
            'status' => 'enroute'
        ]);

        $res = $this->get($uri);

        $res->assertResponseStatus(200);

        $res->seeJsonStructure([
            'data',
            'meta',
        ]);
    }
}
