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
        Schema::create('toys', function (Blueprint $table) {
            $table->id('id_toy');
            $table->string('name');
            $table->string('code')->unique();
            $table->year('made_at')->nullable();
            $table->string('made_in')->nullable();
            $table->string('type')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->timestamps();

            // Foreign key
            $table->foreign('id_user')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toys');
    }
};
