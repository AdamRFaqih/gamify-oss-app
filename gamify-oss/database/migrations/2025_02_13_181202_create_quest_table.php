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
        Schema::create('quests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('title');
            $table->text('description');
            $table->string('role_dev');
            $table->string('difficulty');
            $table->integer('required_level');
            $table->integer('proficiency_reward');
            $table->integer('experience_reward');
            $table->enum('status', ['OPEN', 'CLOSED']);
            $table->foreignId('issue_id')->constrained('issues')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quests');
    }
};
