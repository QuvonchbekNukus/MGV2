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
        Schema::table('users', function (Blueprint $table) {
            // Yangi fieldlar qo'shish
            if (!Schema::hasColumn('users', 'second_name')) {
                $table->string('second_name')->nullable();
            }
            if (!Schema::hasColumn('users', 'third_name')) {
                $table->string('third_name')->nullable();
            }
            if (!Schema::hasColumn('users', 'jinsi')) {
                $table->enum('jinsi', ['erkak', 'ayol'])->nullable();
            }
            if (!Schema::hasColumn('users', 'rank')) {
                $table->string('rank')->nullable();
            }
            if (!Schema::hasColumn('users', 'job_title')) {
                $table->string('job_title')->nullable();
            }
            if (!Schema::hasColumn('users', 'job_responsibility')) {
                $table->text('job_responsibility')->nullable();
            }
            if (!Schema::hasColumn('users', 'is_married')) {
                $table->boolean('is_married')->default(false);
            }
            if (!Schema::hasColumn('users', 'degree')) {
                $table->string('degree')->nullable();
            }
            if (!Schema::hasColumn('users', 'passport_seria')) {
                $table->string('passport_seria')->nullable();
            }
            if (!Schema::hasColumn('users', 'passport_code')) {
                $table->string('passport_code')->nullable();
            }
            if (!Schema::hasColumn('users', 'height')) {
                $table->integer('height')->nullable(); // sm
            }
            if (!Schema::hasColumn('users', 'weight')) {
                $table->integer('weight')->nullable(); // kg
            }
            if (!Schema::hasColumn('users', 'license_code')) {
                $table->string('license_code')->nullable();
            }
            if (!Schema::hasColumn('users', 'id_group')) {
                $table->unsignedBigInteger('id_group')->nullable();
                $table->foreign('id_group')->references('id_group')->on('groups')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Foreign key o'chirish
            if (Schema::hasColumn('users', 'id_group')) {
                $table->dropForeign(['id_group']);
                $table->dropColumn('id_group');
            }
            // Barcha yangi fieldlarni o'chirish
            $columns = [
                'second_name', 'third_name', 'jinsi', 'rank', 'job_title',
                'job_responsibility', 'is_married', 'degree', 'passport_seria',
                'passport_code', 'height', 'weight', 'license_code'
            ];
            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
