<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispatchs extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'name_route',
        'date',
        'hour',
        'minute',
        'usage_rate',
        'plate',
        'authorized_dispatch',
        'type_of_dispatch',
        'vehicle_class_id',
        'enterprise_id',
        'origin_municipality_id',
        'destination_municipality_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
