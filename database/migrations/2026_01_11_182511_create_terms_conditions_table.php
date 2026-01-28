<?php

use App\Models\TermCondition;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('terms_conditions', function (Blueprint $table) {
            $table->id();
            $table->longText('name');
            $table->longText('name_en')->nullable();
            $table->uuid('uuid')->unique();

            $table->enum('role', ['general', 'client', 'doctor'])->default('general');
            $table->string('version'); // مثال: v1.0
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
        TermCondition::whereNull('uuid')->each(function ($term) {
            $term->uuid = Str::uuid();
            $term->save();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terms_conditions');
    }
};
