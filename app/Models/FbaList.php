<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class FbaList extends Model
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
            return $query->where('fba_name', 'LIKE', '%'.$search.'%')
                    ->orWhere('created_at', 'LIKE', '%'.$search.'%');
        }
    }
    public function fbaOutbound(){
        return $this->hasMany(FbaOutbound::class);
    }

    /**
     * @param Builder $query
     * @param Builder $search
     *
     * @return Builder
     */
    public function scopeWithQuery(Builder $query)
    {
        /*return $query->addSelect(['outbound_id' => FbaOutbound::select('shipper_name')
                        ->whereColumn('id', 'clients.shipper_id')
                        ->latest()->take(1)
                    ])
                    */
        return $query;
                   
    }
}
