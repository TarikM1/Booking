<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration_minutes',
        'is_active',
    ];

    protected function casts(): array{

        return[
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function bookings(): BelongsToMany{
        return $this->belongsToMany(Booking::class);
    }
}
