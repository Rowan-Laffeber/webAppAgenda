<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'agenda_id',
        'name',
        'description',
        'start_datetime',
        'end_datetime',
        'color',
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
    ];

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }
}
