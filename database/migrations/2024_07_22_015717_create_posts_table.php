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
            $table->string('init_board')->nullable();
            $table->string('kifu')->nullable();
            $table->string('init_turn')->default('black');
            $table->integer('start_move')->default(0);
            $table->string('black_user_name')->nullable();
            $table->string('white_user_name')->nullable();
            $table->text('begin_text')->nullable();
            $table->text('end_text')->nullable();
            $table->integer('sort');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
