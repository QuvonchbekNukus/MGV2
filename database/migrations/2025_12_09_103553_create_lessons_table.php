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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id('id_lesson');
            $table->string('topic');
            $table->unsignedBigInteger('id_group');
            $table->unsignedBigInteger('id_user');
            $table->date('lesson_date');
            $table->integer('lesson_duration')->nullable(); // minutlarda
            $table->time('start_at');
            $table->time('end_at');
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_group')->references('id_group')->on('groups')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
