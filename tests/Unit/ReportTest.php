<?php

namespace Tests\Unit;

use App\Report;
use Tests\ModelTestCase;

class ReportTest extends ModelTestCase
{
    protected function requiredColumns(): array
    {
        return [
            'id',
            'title',
            'note',
            'status',
            'location',
            'visual_image',
            'time_of_report',
            'status_updated_at',
        ];
    }

    public function testShould_CreateAnItem_Successfully()
    {
        factory(Report::class)->state('acknowledged')->create([
            'title' =>  'test title'
        ]);

        $this->seeInDatabase($this->databaseTableName(), [
            'title' => 'test title',
            'status' => 'acknowledged'
        ]);
    }

    public function testShould_SetDefaultStatus_To_Pending()
    {
        factory(Report::class)->create(['title' => 'outta title ideas']);

        $this->seeInDatabase($this->databaseTableName(), [
            'title' => 'outta title ideas',
            'status' => 'pending'
        ]);
    }
}
