<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BrandMaster extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    public function country(){
        return $this->belongsTo(Country::class, 'country_id');
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
                    ->orWhere('category', 'LIKE', '%'.$search.'%')
                    ->orWhere('ja_name', 'LIKE', '%'.$search.'%')
                    ->orWhere('en_name', 'LIKE', '%'.$search.'%')
                    ->orWhereHas('country', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    });
        }
    }
}
