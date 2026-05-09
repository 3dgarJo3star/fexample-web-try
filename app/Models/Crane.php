<?php

namespace App\Models;

use App\Enums\CraneStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Crane extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('grúas')
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => "Grúa \"{$this->name}\" registrada",
                'updated' => "Grúa \"{$this->name}\" actualizada",
                'deleted' => "Grúa \"{$this->name}\" eliminada",
                default => $eventName,
            });
    }

    protected $fillable = [
        'name',
        'serial_number',
        'brand',
        'year',
        'capacity_tons',
        'status',
        'current_location',
        'diesel_level',
        'total_hours',
        'last_maintenance_hours',
        'is_active',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'status' => CraneStatus::class,
            'is_active' => 'boolean',
            'diesel_level' => 'decimal:2',
            'total_hours' => 'decimal:2',
            'last_maintenance_hours' => 'decimal:2',
            'capacity_tons' => 'decimal:2',
        ];
    }

    public function rentalOrders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RentalOrder::class);
    }

    public function maintenanceRecords(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MaintenanceRecord::class);
    }

    public function statusLogs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CraneStatusLog::class);
    }

    public function getHoursUntilMaintenanceAttribute(): float
    {
        return 400 - ($this->total_hours - $this->last_maintenance_hours);
    }

    public function needsMaintenance(): bool
    {
        return ($this->total_hours - $this->last_maintenance_hours) >= 400;
    }

    public function approachingMaintenance(): bool
    {
        $hoursSinceLast = $this->total_hours - $this->last_maintenance_hours;
        return $hoursSinceLast >= 350 && $hoursSinceLast < 400;
    }
}
