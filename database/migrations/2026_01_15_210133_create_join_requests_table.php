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
        Schema::create('join_requests', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->text('address')->nullable();
            $table->string('email')->unique()->nullable();
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

            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('join_requests');
    }
};
