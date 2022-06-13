<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wdata extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Has Many relationships with Attachments
     * @return HasMany
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(WdataAttachment::class, 'wdata_id');
    }

    /**
     * BelongsTo relationships with WdataPic
     * @return BelongsTo
     */
    public function pic(): BelongsTo
    {
        return $this->belongsTo(WdataPic::class, 'wdata_pic_id');
    }

    /**
     * BelongsTo relationships with InboundStatus
     * @return BelongsTo
     */
    public function inboundStatus(): BelongsTo
    {
        return $this->belongsTo(InboundStatus::class, 'inbound_status_id');
    }

    /**
     * BelongsTo relationships with Container
     * @return BelongsTo
     */
    public function container(): BelongsTo
    {
        return $this->belongsTo(Container::class, 'container_id');
    }

    /**
     * BelongsTo relationships with Carrier
     * @return BelongsTo
     */
    public function deliver(): BelongsTo
    {
        return $this->belongsTo(Carrier::class, 'carrier_id');
    }

    /**
     * BelongsTo relationships with Delivery
     * @return BelongsTo
     */
    public function carrier(): BelongsTo
    {
        return $this->belongsTo(Delivery::class, 'delivery_id');
    }

    /**
     * BelongsTo relationships with WdataStatus
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(WdataStatus::class, 'wdata_status_id');
    }

    /**
     * BelongsTo relationships with Reason
     * @return BelongsTo
     */
    public function reason(): BelongsTo
    {
        return $this->belongsTo(Reason::class, 'reason_id');
    }

    /**
     * BelongsTo relationships with TrackInput
     * @return BelongsTo
     */
    public function trkInput(): BelongsTo
    {
        return $this->belongsTo(TrackInput::class, 'track_input_id');
    }

    /**
     * BelongsTo relationships with ShipmentMethod
     * @return BelongsTo
     */
    public function shipmentMethod(): BelongsTo
    {
        return $this->belongsTo(ShipmentMethod::class, 'shipment_method_id');
    }

    /**
     * BelongsTo relationships with WarehousePic
     * @return BelongsTo
     */
    public function warehousepic(): BelongsTo
    {
        return $this->belongsTo(WarehousePic::class, 'warehouse_pic_id');
    }

    /**
     * BelongsTo relationships with IncompleteStatus
     * @return BelongsTo
     */
    public function incomplete(): BelongsTo
    {
        return $this->belongsTo(IncompleteStatus::class, 'incomplete_status_id');
    }

    /**
     * BelongsTo relationships with DeliveryPlace
     * @return BelongsTo
     */
    public function deliveryPlace(): BelongsTo
    {
        return $this->belongsTo(DeliveryPlace::class, 'delivery_place_id');
    }

    /**
     * BelongsTo relationships with Transfer
     * @return BelongsTo
     */
    public function transfer(): BelongsTo
    {
        return $this->belongsTo(Transfer::class, 'transfer_id');
    }

    /**
     * BelongsTo relationships with PickDirection
     * @return BelongsTo
     */
    public function pickDirection(): BelongsTo
    {
        return $this->belongsTo(PickDirection::class, 'pick_direction_id');
    }

    /**
     * Has Many relationships with Samples/Wdata
     * @return HasMany
     */
    public function jobs(): HasMany
    {
        return $this->hasMany(WdataJob::class, 'wdata_id');
    }

    /**
     * Has Many relationships with CategoryWdata
     * @return HasMany
     */
    public function categories(): HasMany
    {
        return $this->hasMany(CategoryWdata::class, 'wdata_id');
    }

    /**
     * Has Many relationships with ClientWdata
     * @return HasOne
     */
    public function clients(): HasOne
    {
        return $this->hasOne(ClientWdata::class, 'wdata_id');
    }

    /**
     * Has Many relationships with WdataCheck
     * @return HasOne
     */
    public function checkBool(): HasOne
    {
        return $this->hasOne(WdataCheck::class, 'wdata_id');
    }

    /**
     * @param Builder $query
     * @param Builder $search
     *
     * @return Builder
     */
    public function scopeWithQuery(Builder $query)
    {
        return $query->with('checkBool', 'pic:id,name', 'inboundStatus:id,name', 'container:id,name', 'deliver:id,name', 'carrier:id,name', 'status:id,name', 'reason', 'trkInput', 'shipmentMethod', 'warehousepic', 'incomplete', 'deliveryPlace', 'transfer', 'pickDirection', 'jobs.job', 'categories.category', 'clients.client.shipper');
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
                    ->orWhereHas('pic', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    })
                    ->orWhereHas('inboundStatus', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    })
                    ->orWhereHas('container', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    })
                    ->orWhereHas('carrier', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    })
                    ->orWhereHas('status', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    })
                    ->orWhereHas('reason', function($q) use($search){
                        $q->where('reason', 'LIKE', '%'.$search.'%');
                    })
                    ->orWhereHas('trkInput', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    })
                    ->orWhereHas('shipmentMethod', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    })
                    ->orWhereHas('warehousepic', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    })
                    ->orWhereHas('incomplete', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    })
                    ->orWhereHas('deliveryPlace', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    })
                    ->orWhereHas('transfer', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    })
                    ->orWhereHas('pickDirection', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    })
                    ->orWhereHas('jobs.job', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    })
                    ->orWhereHas('categories.category', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    })
                    ->orWhereHas('deliver', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    });
        }
    }
}
