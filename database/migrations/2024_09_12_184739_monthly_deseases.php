<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('monthly_deseases', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('report_id');
            $table->foreign('report_id')->references('id')->on('cp_monthly_reports')->onDelete('cascade');
            $table->string('desease')->nullable();
            $table->integer('no_of_cases')->nullable();
            $table->string('response')->nullable();
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
        Schema::dropIfExists('monthly_deseases');
    }
};
