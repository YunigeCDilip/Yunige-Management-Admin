<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryWdata extends Model
{
    use HasFactory;

    /**
     * BelongsTo relationships with WdataCategory
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(WdataCategory::class, 'wdata_category_id');
    }
}
