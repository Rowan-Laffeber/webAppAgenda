<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgendaInvitation extends Model
{
    // Disables Laravel's automatic managing of updated_at
    public $timestamps = false; 

    protected $fillable = [
        'agenda_id',
        'sender_id',
        'receiver_id',
        'invitation_status',
        'created_at',
        'responded_at'
    ];
}
