<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientAmazonProgress extends Model
{
    use HasFactory;

    public function progress(){
        return $this->belongsTo(AmazonProgress::class, 'amazon_progress_id');
    }

    public function client(){
        return $this->belongsTo(Client::class, 'client_id');
    }
}
