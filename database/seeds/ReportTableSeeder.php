<?php

use App\Report;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class ReportTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // we'll create reports for the 3 different statuses
        // in summary, we should have in our database
        // 5 acknowledged reports, 0 onsite report, 1 enroute report
        // 4 pending reports
        factory(Report::class, 5)->state('acknowledged')->create();

        factory(Report::class, 1)->state('enroute')->create();

        factory(Report::class, 4)->state('pending')->create();

        Model::reguard();
    }
}
