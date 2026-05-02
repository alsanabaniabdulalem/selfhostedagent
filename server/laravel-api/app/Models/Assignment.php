<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assignment extends Model
{
    use HasFactory;

    // API-managed fields for assignment lifecycle tracking.
    protected $fillable = [
        'equipment_id',
        'user_id',
        'assigned_at',
        'due_at',
        'returned_at',
        'notes',
    ];

    // Date casting keeps comparisons and JSON serialization consistent.
    protected $casts = [
        'assigned_at' => 'date',
        'due_at' => 'date',
        'returned_at' => 'date',
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scope for active (not yet returned) assignments.
    public function scopeActive($query)
    {
        return $query->whereNull('returned_at');
    }
}
