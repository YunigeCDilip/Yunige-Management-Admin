<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoomRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'name',
        'location_id',
        'activation_code',
        'status',
        'created_at',
        'updated_at',
    ];
   
}
