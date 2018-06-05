<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTBFailedJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_FailedJobs', function (Blueprint $table) {
            $table->bigIncrements('failedJobs_id');
            $table->text('failedJobs_connection');
            $table->text('failedJobs_queue');
            $table->longText('failedJobs_payload');
            $table->longText('failedJobs_exception');
            $table->timestamp('failedJobs_failed_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TB_FailedJobs');
    }
}
