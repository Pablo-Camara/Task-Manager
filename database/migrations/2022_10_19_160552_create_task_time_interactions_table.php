<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_time_interactions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('task_id');

            $table->timestamp('started_at')->nullable();
            $table->date('started_at_day')->nullable()->index();

            $table->timestamp('ended_at')->nullable();
            $table->date('ended_at_day')->nullable()->index();

            $table->unsignedBigInteger('hours')->default(0);
            $table->unsignedBigInteger('minutes')->default(0);
            $table->unsignedBigInteger('seconds')->default(0);
            $table->unsignedBigInteger('total_seconds_spent')->default(0);

            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_time_interactions');
    }
};
