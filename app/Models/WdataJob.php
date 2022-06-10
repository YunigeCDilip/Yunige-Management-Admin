<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WdataJob extends Model
{
    use HasFactory;

    /**
     * BelongsTo relationships with WarehouseJob
     * @return BelongsTo
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(WarehouseJob::class, 'warehouse_job_id');
    }
}
