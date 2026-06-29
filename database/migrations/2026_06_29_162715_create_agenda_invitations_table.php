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
        Schema::create('agenda_invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agenda_id')
                ->constrained('agendas')
                ->onDelete('cascade');
            $table->foreignId('sender_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('receiver_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->enum('invitation_status', ['pending', 'accepted', 'declined'])->default('pending');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('responded_at')->nullable();

            // Prevents spamming duplicate invitations to the same agenda
            $table->unique(['agenda_id', 'receiver_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agenda_invitations');
    }
};
