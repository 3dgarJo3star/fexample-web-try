<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Client extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('clientes')
            ->setDescriptionForEvent(fn (string $eventName) => match ($eventName) {
                'created' => "Cliente \"{$this->company_name}\" registrado",
                'updated' => "Cliente \"{$this->company_name}\" actualizado",
                'deleted' => "Cliente \"{$this->company_name}\" eliminado",
                default => $eventName,
            });
    }

    protected $fillable = [
        'company_name',
        'contact_name',
        'phone',
        'email',
        'address',
        'rfc',
        'notes',
    ];

    public function rentalOrders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RentalOrder::class);
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class);
    }
}
