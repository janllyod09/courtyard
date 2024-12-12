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
                $table->string('firstname');
                $table->string('middlename');
                $table->string('lastname');
                $table->string('address')->nullable();
                $table->string('position')->nullable();
                $table->string('qualification')->nullable();
                // $table->string('file_name')->nullable();
                // $table->string('file_path')->nullable();
                $table->string('property_title_path')->nullable();
                $table->string('hoa_due_certificate_path')->nullable();
                $table->string('special_power_of_attorney_path')->nullable();
                $table->string('property_title_name')->nullable();
                $table->string('hoa_due_certificate_name')->nullable();
                $table->string('special_power_of_attorney_name')->nullable();
                $table->string('email', 50);
                $table->string('password', 1000);
                $table->string('user_role')->nullable();
                $table->string('active_status')->nullable();
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
