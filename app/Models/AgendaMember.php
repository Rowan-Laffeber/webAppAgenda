<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgendaMember extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'agenda_id',
        'user_id',
        'joined_at'
    ];
}
