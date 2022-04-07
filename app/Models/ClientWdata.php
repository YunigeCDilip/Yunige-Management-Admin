<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientWdata extends Model
{
    use HasFactory;

    public function wdata(){
        return $this->belongsTo(Wdata::class, 'wdata_id');
    }
}
