<?php

namespace Tests\Utils;

use Illuminate\Support\Facades\Schema;
use Laravel\Lumen\Testing\DatabaseMigrations;

trait TestsDatabase
{
    use DatabaseMigrations;

    /**
     * Get the table name of the database
     *
     * @return string
     */
    abstract protected function databaseTableName(): string;

    /**
     * Get the required columns that should exists
     *
     * @return array
     */
    abstract protected function requiredColumns(): array;

    public function testDatabaseTable_Exists()
    {
        $this->assertTrue(Schema::hasTable($this->databaseTableName()));
    }

    /**
     * @dataProvider columnDataProvider
     */
    public function testDatabaseTable_Has_RequiredColumns($table, $column)
    {
        $this->assertTrue(Schema::hasColumn($table, $column), "$column column does not exist");
    }

    public function columnDataProvider()
    {
        $data = [];
        $columns = $this->requiredColumns();
        $table = $this->databaseTableName();

        foreach ($columns as $column_name) {
            $data[] = [$table, $column_name];
        }

        return $data;
    }
}
