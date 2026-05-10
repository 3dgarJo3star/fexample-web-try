<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\{PaymentMethod, RentalOrderStatus};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class RentalOrder extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('órdenes')
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => "Orden \"{$this->order_number}\" creada",
                'updated' => "Orden \"{$this->order_number}\" modificada",
                'deleted' => "Orden \"{$this->order_number}\" eliminada",
                default => $eventName,
            });
    }

    protected $fillable = [
        'order_number',
        'crane_id',
        'operator_id',
        'client_id',
        'zone_id',
        'service_location',
        'start_date',
        'arrival_time',
        'start_time',
        'end_time',
        'departure_time',
        'status',
        'payment_method',
        'authorized_by_name',
        'authorized_by_phone',
        'client_signature',
        'internal_notes',
    ];

    protected function casts(): array
    {
        return [
            'status' => RentalOrderStatus::class,
            'payment_method' => PaymentMethod::class,
            'start_date' => 'date',
            'client_signature' => 'boolean',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model) {
            if (empty($model->order_number)) {
                $year = now()->year;
                $count = static::whereYear('created_at', $year)->count() + 1;
                $model->order_number = 'GRU-'.$year.'-'.str_pad((string) $count, 3, '0', STR_PAD_LEFT);
            }
        });
    }

    public function crane(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Crane::class);
    }

    public function operator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Operator::class);
    }

    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function zone(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    public function costs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RentalOrderCost::class);
    }

    public function scopeForClient(\Illuminate\Database\Eloquent\Builder $query, ?int $clientId): void
    {
        if ($clientId) {
            $query->where('client_id', $clientId);
        } else {
            $query->whereRaw('1 = 0');
        }
    }

    public function getTotalCostAttribute(): float
    {
        return $this->costs->sum('amount');
    }
}
