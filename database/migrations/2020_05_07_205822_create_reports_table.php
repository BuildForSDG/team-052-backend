<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            // short note can be left behind by the reporter
            $table->text('note')->nullable();
            // defaults to pending
            $table->char('status')->default(0);
            $table->string('location');
            $table->string('visual_image');
            $table->timestamp('time_of_report')->nullable();
            $table->timestamp('status_updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
