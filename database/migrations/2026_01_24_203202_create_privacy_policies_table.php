<?php

use App\Models\PrivacyPolicy;
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
        Schema::create('privacy_policies', function (Blueprint $table) {

            $table->id();
            $table->longText('text');
            $table->longText('text_en')->nullable();

            $table->uuid('uuid')->unique();
            $table->timestamps();
        });

        PrivacyPolicy::whereNull('uuid')->each(function ($term) {
            $term->uuid = Str::uuid();
            $term->save();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('privacy_policies');
    }
};
