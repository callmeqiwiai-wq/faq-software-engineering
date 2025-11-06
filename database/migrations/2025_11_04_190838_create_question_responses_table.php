<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('question_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_result_id')->constrained()->onDelete('cascade');
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->text('response_text')->nullable(); // For text answers
            $table->json('selected_answers')->nullable(); // For multiple choice answers
            $table->boolean('is_correct');
            $table->integer('points_earned');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_responses');
    }
};
