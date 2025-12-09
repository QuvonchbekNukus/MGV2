<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('subject_type')->nullable(); // Model nomi
            $table->unsignedBigInteger('subject_id')->nullable(); // Model ID
            $table->string('action'); // create, update, delete, view, login, logout
            $table->text('description')->nullable();
            $table->json('properties')->nullable(); // Old/New values
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('device')->nullable(); // mobile, tablet, desktop
            $table->string('browser')->nullable(); // chrome, firefox, safari
            $table->string('platform')->nullable(); // windows, mac, linux
            $table->timestamps();

            // Indexes for performance
            $table->index('user_id');
            $table->index(['subject_type', 'subject_id']);
            $table->index('action');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
