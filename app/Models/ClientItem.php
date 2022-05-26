<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientItem extends Model
{
    use HasFactory;

    public function item(){
        return $this->belongsTo(ItemMaster::class, 'item_master_id');
    }

    public function client(){
        return $this->belongsTo(Client::class, 'client_id');
    }
}
