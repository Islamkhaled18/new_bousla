<?php

use App\Models\Faq;
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
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('question');
            $table->text('answer');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

        Faq::whereNull('uuid')->each(function ($term) {
            $term->uuid = Str::uuid();
            $term->save();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
