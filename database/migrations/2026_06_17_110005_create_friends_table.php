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
    Schema::create('friends', function (Blueprint $table) {
        // Explicitly point both columns to the 'users' table
        $table->foreignId('user_id')
            ->constrained('users')
            ->onDelete('cascade');
        $table->foreignId('friend_id')
            ->constrained('users')
            ->onDelete('cascade');

        $table->timestamps();

        // Prevent duplicate friendship entries
        $table->primary(['user_id', 'friend_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friends');
    }
};
