<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientSdata extends Model
{
    use HasFactory;

    public function sdata(){
        return $this->belongsTo(Sdata::class, 'sdata_id');
    }
}
