<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('game_file')->nullable();
            $table->string('thumbnail');
            $table->string('question');
            $table->string('answer');
            $table->json('options')->nullable();
            $table->enum('type', ['guess_part', 'qa', 'lesson'])->default('guess_part');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('games');
    }
};
