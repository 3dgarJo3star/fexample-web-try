<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

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
