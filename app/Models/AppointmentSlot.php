<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentSlot extends Model
{
    protected $fillable = [
        'start_at',
        'is_open',
    ];

    protected function casts(): array {
        return[
            'start_at' => 'datetime',
            'is_open' => 'boolean',
        ];
    }
}
