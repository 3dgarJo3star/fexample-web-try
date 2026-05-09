<?php

namespace App\Models;

use App\Enums\MaintenanceStatus;
use App\Enums\MaintenanceType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class MaintenanceRecord extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('mantenimiento')
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => "Mantenimiento registrado para grúa ID {$this->crane_id}",
                'updated' => "Mantenimiento ID {$this->id} actualizado",
                'deleted' => "Mantenimiento ID {$this->id} eliminado",
                default => $eventName,
            });
    }

    protected $fillable = [
        'crane_id',
        'type',
        'hours_at_maintenance',
        'next_maintenance_hours',
        'scheduled_date',
        'completed_date',
        'description',
        'cost',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'type' => MaintenanceType::class,
            'status' => MaintenanceStatus::class,
            'scheduled_date' => 'date',
            'completed_date' => 'date',
            'hours_at_maintenance' => 'decimal:2',
            'next_maintenance_hours' => 'decimal:2',
            'cost' => 'decimal:2',
        ];
    }

    public function crane(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Crane::class);
    }
}
