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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['admin', 'client', 'doctor'])->default('client');
            $table->string('slug')->unique();

            //required for all
            $table->string('first_name');
            $table->string('last_name');
            $table->string('password')->nullable();
            $table->string('phone');
            $table->boolean('is_active')->default(1);

            //required for admins and doctors
            $table->text('address')->nullable();

            //required for client and doctor
            $table->string('email')->unique()->nullable();

            //required for doctor
            $table->text('about_me')->nullable();
            $table->string('id_number')->unique()->nullable();
            $table->foreignId('job_title_id')->nullable()->constrained('job_titles')->cascadeOnDelete();
            $table->foreignId('area_id')->nullable()->constrained('areas')->cascadeOnDelete();
            $table->string('organization_name')->nullable();
            $table->string('organization_phone_first')->nullable();
            $table->string('organization_phone_second')->nullable();
            $table->string('organization_phone_third')->nullable();
            $table->string('organization_location_url')->nullable();
            $table->integer('building_number')->nullable();
            $table->integer('floor_number')->nullable();
            $table->integer('apartment_number')->nullable();
            $table->string('personal_image')->nullable();
            $table->string('logo')->nullable();
            $table->string('id_image_front')->nullable();
            $table->string('id_image_back')->nullable();
            $table->string('graduation_certificate')->nullable();
            $table->string('professional_license')->nullable();
            $table->string('syndicate_card')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
