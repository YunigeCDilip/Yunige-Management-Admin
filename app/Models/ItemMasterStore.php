<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemMasterStore extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * BelongsTo relationships with ItemMaster
     * @return BelongsTo
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(ItemMaster::class, 'item_master_id');
    }

    /**
     * @param Builder $query
     * @param Builder $search
     *
     * @return Builder
     */
    public function scopeWithQuery(Builder $query)
    {
        return $query->with('item');
    }
    
    /**
     * @param Builder $query
     * @param Builder $search
     *
     * @return Builder
     */
    public function scopeSearch(Builder $query, $search)
    {
        if ($search != '') {
            return $query->where('quantity', 'LIKE', '%' . $search . '%')
                ->orWhereHas('item', function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%');
                });
        }
    }
}
