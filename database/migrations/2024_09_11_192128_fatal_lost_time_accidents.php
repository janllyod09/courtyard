<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('fatal_lost_time_accidents', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('report_id');
            $table->foreign('report_id')->references('id')->on('cp_monthly_reports')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('gender')->nullable();
            $table->string('position')->nullable();
            $table->date('date_of_accident_illness')->nullable();
            $table->time('time')->nullable();
            $table->string('location')->nullable();
            $table->boolean('has_physical_injury')->nullable();
            $table->boolean('has_property_damage')->nullable();
            $table->boolean('is_service_contractor')->nullable();
            $table->string('company')->nullable();
            $table->string('cause_of_accident_illness')->nullable();
            $table->boolean('is_unsafe_acts')->nullable();
            $table->text('is_unsafe_acts_description')->nullable();
            $table->boolean('is_unsafe_conditions')->nullable();
            $table->text('is_unsafe_conditions_description')->nullable();
            $table->text('kind_of_accident')->nullable();
            $table->text('type_of_injury')->nullable();
            $table->text('part_of_body_injured')->nullable();
            $table->text('treatment')->nullable();
            $table->double('cost_of_mitigation')->nullable();
            $table->double('cost_of_property_damage')->nullable();
            $table->boolean('is_performing_routine_work')->nullable();
            $table->text('is_not_performing_routine_work_description')->nullable();
            $table->text('description_of_incident')->nullable();
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
        Schema::dropIfExists('fatal_lost_time_accidents');
    }
};
