<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemMaster extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    public function category(){
        return $this->belongsTo(ItemCategory::class, 'item_category_id');
    }

    public function shipper(){
        return $this->belongsTo(Shipper::class, 'shipper_id');
    }

    public function label(){
        return $this->belongsTo(ItemLabel::class, 'item_label_id');
    }

    public function clientItems(){
        return $this->hasOne(ClientItem::class)->latest();
    }

    public function brands(){
        return $this->belongsTo(BrandMaster::class, 'brand_master_id');
    }

    public function productTypes(){
        return $this->hasMany(ItemMasterProductType::class);
    }

    public function images(){
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
        if($search != ''){
            return $query->where('product_name', 'LIKE', '%'.$search.'%')
                    ->orWhere('product_barcode', 'LIKE', '%'.$search.'%')
                    ->orWhere('barcode_entry_date', 'LIKE', '%'.$search.'%')
                    ->orWhereHas('category', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    })
                    ->orWhereHas('shipper', function($q) use($search){
                        $q->where('shipper_name', 'LIKE', '%'.$search.'%');
                    })
                    ->orWhereHas('label', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    })
                    ->orWhereHas('brands', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    });
        }
    }
}
