<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTBCurrentJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_CurrentJobs', function (Blueprint $table) {
            $table->bigIncrements('currentJobsid');
            $table->string('currentJobs_queue')->index();
            $table->longText('currentJobs_payload');
            $table->unsignedTinyInteger('currentJobs_attempts');
            $table->unsignedInteger('currentJobs_reserved_at')->nullable();
            $table->unsignedInteger('currentJobs_available_at');
            $table->unsignedInteger('currentJobs_created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TB_CurrentJobs');
    }
}
