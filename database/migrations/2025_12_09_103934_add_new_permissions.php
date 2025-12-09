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
        // Bu migration Spatie permission jadvalidan keyin ishga tushadi
        // Ammo migrations orderi-ga ko'ra, permissions jadval allaqachon mavjud
        // Shuning uchun biz seeder-da qo'shamiz
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
