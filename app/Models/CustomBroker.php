<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomBroker extends Model
{
    use HasFactory, SoftDeletes;

    public function wdatas(){
        return $this->hasMany(WdataCustomBroker::class);
    }

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
            return $query->where('name', 'LIKE', '%'.$search.'%')
                    ->orWhere('email', 'LIKE', '%'.$search.'%')
                    ->orWhere('telephone_no', 'LIKE', '%'.$search.'%')
                    ->orWhere('fax_number', 'LIKE', '%'.$search.'%')
                    ->orWhereHas('wdatas.wdata', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    });
        }
    }
}
