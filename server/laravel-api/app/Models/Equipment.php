<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipment extends Model
{
    use HasFactory;

    // Fillable columns accepted from validated API payloads.
    protected $fillable = [
        'asset_tag',
        'name',
        'category',
        'serial_number',
        'status',
        'location',
    ];

    // A single equipment item can have many assignment history records.
    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    // Helper scope for fetching currently available equipment quickly.
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }
}
