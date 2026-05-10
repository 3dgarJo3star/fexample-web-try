<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CraneStatusLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'crane_id',
        'operator_id',
        'is_on',
        'is_working',
        'location',
        'diesel_level',
        'hours_reading',
        'notes',
        'logged_at',
    ];

    protected function casts(): array
    {
        return [
            'is_on' => 'boolean',
            'is_working' => 'boolean',
            'diesel_level' => 'decimal:2',
            'hours_reading' => 'decimal:2',
            'logged_at' => 'datetime',
        ];
    }

    public function crane(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Crane::class);
    }

    public function operator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Operator::class);
    }
}
