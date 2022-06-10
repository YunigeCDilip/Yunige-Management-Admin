<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SdataItemMaster extends Model
{
    use HasFactory;

    /**
     * BelongsTo relationships with user
     * @return BelongsTo
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(ItemMaster::class, 'item_master_id');
    }
}
