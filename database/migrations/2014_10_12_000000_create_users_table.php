<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id('id');
                $table->string('name');
                $table->string('company_name');
                $table->string('registrant_name');
                $table->string('email', 50);
                $table->string('password', 1000);
                $table->string('user_role')->nullable();
                $table->string('active_status')->nullable();
                $table->string('contact_num')->unique()->nullable();
                $table->string('mining_type')->nullable();
                $table->string('product')->nullable();
                $table->string('permit_type')->nullable();
                $table->string('permit_location')->nullable();
                $table->string('profile_photo_path')->nullable();
                $table->rememberToken();
                $table->timestamps();
            });
        }
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('users')) {
            Schema::dropIfExists('users');
        }
    }
};
