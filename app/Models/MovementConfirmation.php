<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MovementConfirmation extends Model
{
    use HasFactory;
    
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
                    ->orWhereRaw("IF(active_status = 1, 'Active', 'InActive') like ?",[$search])
                    ->orWhere('created_at', 'LIKE', '%'.$search.'%');
        }
    }
}
