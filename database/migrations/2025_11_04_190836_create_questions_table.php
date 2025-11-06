<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->string('type')->checkIn(['single', 'multiple', 'text']);
            $table->text('explanation')->nullable();
            $table->integer('points')->default(1);
            $table->integer('order')->default(0);
            $table->unsignedBigInteger('correct_answer_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }
};