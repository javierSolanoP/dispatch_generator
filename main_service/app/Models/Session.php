<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_of_session'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
