<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    public function category(){
        return $this->belongsTo(ClientCategory::class, 'client_category_id');
    }

    public function shipper(){
        return $this->belongsTo(Shipper::class);
    }

    public function contact(){
        return $this->hasOne(ClientContact::class);
    }

    /**
     * @param Builder $query
     * @param Builder $search
     *
     * @return Builder
     */
    public function scopeWithQuery(Builder $query)
    {
        return $query->addSelect(['shipper_name' => Shipper::select('shipper_name')
                        ->whereColumn('id', 'clients.shipper_id')
                        ->latest()->take(1)
                    ])
                    ->addSelect(['category_name' => ClientCategory::select('name')
                        ->whereColumn('id', 'clients.client_category_id')
                        ->latest()->take(1)
                    ])
                    ->addSelect(['resp_person' => ClientContact::select('name')
                        ->whereColumn('client_id', 'clients.id')
                        ->latest()->take(1)
                    ])
                    ->addSelect(['contact_number' => ClientContact::select('contact_number')
                        ->whereColumn('client_id', 'clients.id')
                        ->latest()->take(1)
                    ]);
    }
    
    /**
     * @param Builder $query
     * @param Builder $search
     *
     * @return Builder
     */
    public function scopeSearch(Builder $query, $search)
    {
        // \Log::info($search);
        if($search != ''){
            return $query->where('serial_number', 'LIKE', '%'.$search.'%')
                    ->orWhere('client_name', 'LIKE', '%'.$search.'%')
                    ->orWhere('ja_name', 'LIKE', '%'.$search.'%')
                    ->orWhere('en_name', 'LIKE', '%'.$search.'%')
                    ->orWhereHas('category', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%');
                    })
                    ->orWhereHas('shipper', function($q) use($search){
                        $q->where('shipper_name', 'LIKE', '%'.$search.'%');
                    })
                    ->orWhereHas('contact', function($q) use($search){
                        $q->where('name', 'LIKE', '%'.$search.'%')
                        ->orWhere('contact_number', 'LIKE', '%'.$search.'%');
                    });
        }
    }
}
