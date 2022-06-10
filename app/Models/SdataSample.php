<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SdataSample extends Model
{
    use HasFactory;

    /**
     * BelongsTo relationships with Wdata
     * @return BelongsTo
     */
    public function wdata(): BelongsTo
    {
        return $this->belongsTo(Wdata::class, 'wdata_id');
    }
}
