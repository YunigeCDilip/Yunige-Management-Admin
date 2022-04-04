<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use phpDocumentor\Reflection\Types\Self_;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
     * Get the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function serialNumber(): Attribute
    {
        
        // Log::info($latestData);
        return Attribute::make(
            get: fn ($value) => 'c'.sprintf("%04s", $value),
            set: fn ($latestData) => $latestData+1,
        );
    }

    /**
     * Get the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function clientName(): Attribute
    {
        $latestData = Self::withTrashed()->max('serial_number');
        // IF({ClientJP}="",{ClientEng},IF({ClientEng}="",{ClientJP},CONCATENATE(UPPER({ClientEng}),"-",{ClientJP})))
        // {ClientNameDisp}&"_"&{ClientNo}
        $clientDisplay = "";
        if($this->ja_name == "" && $this->en_name == "") $clientDisplay = "_".'c'.sprintf("%04s", $latestData+1);
        else if($this->ja_name == "") $clientDisplay = $this->en_name;
        else if($this->en_name == "") $clientDisplay = $this->ja_name;
        else $clientDisplay = $this->en_name."-".$this->ja_name."_".'c'.sprintf("%04s", $latestData+1);

        return Attribute::make(
            set: fn ($value) => $clientDisplay,
        );
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
