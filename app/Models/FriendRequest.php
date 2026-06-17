<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FriendRequest extends Model
{
    // Vertel Laravel welke kolommen ingevuld mogen worden
    protected $fillable = ['sender_id', 'receiver_id', 'request_status'];

    // Relatie naar de gebruiker die het verzoek stuurde
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Relatie naar de gebruiker die het verzoek ontvangt
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}