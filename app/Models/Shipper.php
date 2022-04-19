<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipper extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];
    
    /**
     * @param Builder $query
     * @param Builder $search
     *
     * @return Builder
     */
    public function scopeSearch(Builder $query, $search)
    {
        if($search != ''){
            return $query->where('shipper_name', 'LIKE', '%'.$search.'%')
                    ->orWhere('created_at', 'LIKE', '%'.$search.'%');
        }
    }
}