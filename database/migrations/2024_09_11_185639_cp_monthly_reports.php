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
            $table->integer('man_hours')->nullable();
            $table->integer('male_workers')->nullable();
            $table->integer('female_workers')->nullable();
            $table->integer('service_contractors')->nullable();
            $table->integer('non_lost_time_accident')->nullable();
            $table->integer('non_fatal_lost_time_accident')->nullable();
            $table->integer('fatal_lost_time_accident')->nullable();
            $table->integer('nflt_days_lost')->nullable();
            $table->integer('flt_days_lost')->nullable();
            $table->string('minutes')->nullable();
            $table->boolean('status')->nullable();
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
