<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cp_monthly_reports', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('month')->nullable();
            $table->date('date_encoded')->nullable();
            $table->integer('man_hours')->default(0);
            $table->integer('male_workers')->default(0);
            $table->integer('female_workers')->default(0);
            $table->integer('service_contractors')->default(0);
            $table->integer('non_lost_time_accident')->default(0);
            $table->integer('non_fatal_lost_time_accident')->default(0);
            $table->integer('fatal_lost_time_accident')->default(0);
            $table->integer('days_lost')->default(0);
            $table->string('minutes')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cp_monthly_reports');
    }
};
