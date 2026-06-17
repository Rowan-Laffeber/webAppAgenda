<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'color',
    ];

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
