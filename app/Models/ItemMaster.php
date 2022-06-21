<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ItemMaster extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * BelongsTo relationships with ItemCategory
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ItemCategory::class, 'item_category_id');
    }

    /**
     * BelongsTo relationships with Shipper
     * @return BelongsTo
     */
    public function shipper(): BelongsTo
    {
        return $this->belongsTo(Shipper::class, 'shipper_id');
    }

    /**
     * BelongsTo relationships with ItemLabel
     * @return BelongsTo
     */
    public function label(): BelongsTo
    {
        return $this->belongsTo(ItemLabel::class, 'item_label_id');
    }

    /**
     * HasOne relationships with ClientItem
     * @return HasOne
     */
    public function clientItems(): HasOne
    {
        return $this->hasOne(ClientItem::class)->latest();
    }

    /**
     * BelongsTo relationships with BrandMaster
     * @return BelongsTo
     */
    public function brands(): BelongsTo
    {
        return $this->belongsTo(BrandMaster::class, 'brand_master_id');
    }

    /**
     * HasMany relationships with ItemMasterProductType
     * @return HasMany
     */
    public function productTypes(): HasMany
    {
        return $this->hasMany(ItemMasterProductType::class);
    }

    /**
     * HasMany relationships with ItemImage
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(ItemImage::class);
    }

    /**
     * @param Builder $query
     * @param Builder $search
     *
     * @return Builder
     */
    public function scopeWithQuery(Builder $query)
    {
        return $query->with('category', 'shipper', 'label', 'clientItems.client', 'brands.country', 'productTypes.type', 'images');
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
            return $query->where('product_name', 'LIKE', '%' . $search . '%')
                ->orWhere('product_barcode', 'LIKE', '%' . $search . '%')
                ->orWhere('barcode_entry_date', 'LIKE', '%' . $search . '%')
                ->orWhereHas('category', function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%');
                })
                ->orWhereHas('shipper', function ($q) use ($search) {
                    $q->where('shipper_name', 'LIKE', '%' . $search . '%');
                })
                ->orWhereHas('label', function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%');
                })
                ->orWhereHas('brands', function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%');
                });
        }
    }
}
