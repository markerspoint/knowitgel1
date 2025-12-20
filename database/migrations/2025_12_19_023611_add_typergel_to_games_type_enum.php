<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE `games` MODIFY COLUMN `type` ENUM('guess_part', 'qa', 'lesson', 'typergel') DEFAULT 'guess_part'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE `games` MODIFY COLUMN `type` ENUM('guess_part', 'qa', 'lesson') DEFAULT 'guess_part'");
    }
};
