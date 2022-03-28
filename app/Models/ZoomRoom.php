<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ZoomRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'name',
        'location_id',
        'activation_code',
        'status',
        'created_at',
        'updated_at',
    ];

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
                    ->orWhere('status', 'LIKE', '%'.$search.'%')
                    ->orWhereRaw("IF(status = '', 'Offline', 'Online') like ?",[$search])
                    ->orWhereDate('created_at', $search);
        }
    }
   
}
