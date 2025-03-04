<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('question'); // Question text
            $table->string('answer'); // Correct answer
            $table->json('options')->nullable(); // Multiple choices for Q&A
            $table->enum('type', ['guess_part', 'qa']); // Type of game
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('games');
    }
};
