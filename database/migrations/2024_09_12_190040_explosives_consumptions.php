<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('explosives_consumptions', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('report_id');
            $table->foreign('report_id')->references('id')->on('cp_monthly_reports')->onDelete('cascade');
            $table->string('blasting_contractor')->nullable();
            $table->double('dynamite')->nullable();
            $table->double('detonating_cord')->nullable();
            $table->integer('non_elec_blasting_caps')->nullable();
            $table->integer('elec_blasting_caps')->nullable();
            $table->integer('fuse_lighter')->nullable();
            $table->integer('connectors')->nullable();
            $table->double('ammonium_nitrate')->nullable();
            $table->integer('shotshell_primer')->nullable();
            $table->integer('primer')->nullable();
            $table->double('emulsion')->nullable();
            $table->integer('others')->nullable();
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
        Schema::dropIfExists('explosives_consumptions');
    }
};
