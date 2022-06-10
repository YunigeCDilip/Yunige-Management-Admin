<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sdata extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Has Many relationships with Attachments
     * @return HasMany
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(SdataAttachment::class, 'sdata_id');
    }

    /**
     * Has Many relationships with Samples/Wdata
     * @return HasMany
     */
    public function samples(): HasMany
    {
        return $this->hasMany(SdataSample::class, 'sdata_id');
    }

    /**
     * Has Many relationships with Samples/Wdata
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(SdataItemMaster::class, 'sdata_id');
    }

    /**
     * BelongsTo relationships with user
     * @return BelongsTo
     */
    public function labelRequester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'label_requester_id');
    }

    /**
     * BelongsTo relationships with user
     * @return BelongsTo
     */
    public function incharge(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * BelongsTo relationships with AmazonProgress
     * @return BelongsTo
     */
    public function amazonProgress(): BelongsTo
    {
        return $this->belongsTo(AmazonProgress::class, 'amazon_progress_id');
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
        return $query->with('samples.wdata:id,name', 'items.item', 'labelRequester:id,name,email', 'incharge:id,name,email', 'amazonProgress:id,name', 'delivery:id,name');
    }

    /**
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
                    ->orWhereHas('amazonProgress', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    })
                    ->orWhereHas('delivery', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    })
                    ->orWhereHas('incharge', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    })
                    ->orWhereHas('labelRequester', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    });
        }
    }
}
