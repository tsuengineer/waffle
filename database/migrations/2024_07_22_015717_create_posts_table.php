<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->ulid('ulid')->unique()->comment('ULID');
            $table->string('title');
            $table->string('init_board');
            $table->string('kifu');
            $table->integer('start_move');
            $table->string('black_user_name');
            $table->string('white_user_name');
            $table->text('begin_text')->nullable();
            $table->text('end_text')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
