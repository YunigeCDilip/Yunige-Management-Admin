<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Outbound extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'warehouse_in_charge' => 'array'
    ];

    /**
     * Has Many relationships with Attachments
     * @return HasMany
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(OutboundAttachment::class, 'outbound_id');
    }

    /**
     * Has Many relationships with FbaOutbound
     * @return HasMany
     */
    public function fbalists(): HasMany
    {
        return $this->hasMany(FbaOutbound::class, 'outbound_id');
    }

    /**
     * BelongsTo relationships with Wdata
     * @return BelongsTo
     */
    public function wdata(): BelongsTo
    {
        return $this->belongsTo(Wdata::class, 'wdata_id');
    }

    /**
     * BelongsTo relationships with Delivery
     * @return BelongsTo
     */
    public function delivery(): BelongsTo
    {
        return $this->belongsTo(Delivery::class, 'delivery_id');
    }

    /**
     * @param Builder $query
     * @param Builder $search
     *
     * @return Builder
     */
    public function scopeWithQuery(Builder $query)
    {
        return $query->with('attachments', 'fbalists', 'wdata:id,name','delivery:id,name');
    }

    /**
     * Grouped Attachments
     * @return mixed
     */
    public function groupedAttachments()
    {
        return $this->attachments->groupBy('type');
    }
    
    /**
     * @param Builder $query
     * @param Builder $search
     *
     * @return Builder
     */
    public function scopeSearch(Builder $query, $search)
    {
        if($search != ''){
            return $query->where('name', 'LIKE', '%'.$search.'%')
                    ->orWhereHas('wdata', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    })
                    ->orWhereHas('delivery', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    });
        }
    }
}
