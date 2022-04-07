<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'takatsu_working_date' => 'datetime',
    ];

    public function category(){
        return $this->belongsTo(ClientCategory::class, 'client_category_id');
    }

    public function requestedClient(){
        return $this->belongsTo(Client::class, 'request_client_id');
    }

    public function shipper(){
        return $this->belongsTo(Shipper::class);
    }

    public function contact(){
        return $this->hasOne(ClientContact::class);
    }

    public function amazonProgress(){
        return $this->hasMany(ClientAmazonProgress::class);
    }

    public function sdatas(){
        return $this->hasMany(ClientSdata::class);
    }

    public function items(){
        return $this->hasMany(ClientItem::class);
    }

    public function wdatas(){
        return $this->hasMany(ClientWdata::class);
    }

    public function movement(){
        return $this->belongsTo(MovementConfirmation::class, 'movement_confirmation_id');
    }

    public function classification(){
        return $this->belongsTo(ForeignDeliveryClassification::class, 'foreign_delivery_classifications_id');
    }

    /**
     * Get the user's first name.
     *
     * @return Attribute
     */
    protected function serialNumber(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => 'c'.sprintf("%04s", $value)
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

    /**
     * Save client related data
     * @param Request $request
     * 
     * @return void
     */
    public function saveClientsDatas($request)
    {
        $sdatas = $request->sdata;
        if($request->has('sdata') && count($sdatas) > 0){
            ClientSdata::where('client_id', $this->id)->delete();
            foreach($sdatas as $d)
            {
                $cd = new ClientSdata();
                $cd->client_id = $this->id;
                $cd->sdata_id = $d;
                $cd->save();
            }
        }
        $wdatas = $request->wdata;
        if($request->has('wdata') && $wdatas){
            ClientWdata::where('client_id', $this->id)->delete();
            foreach($wdatas as $d)
            {
                $cd = new ClientWdata();
                $cd->client_id = $this->id;
                $cd->wdata_id = $d;
                $cd->save();
            }
        }
        $clients = $request->item;
        if($request->has('item') && $clients){
            ClientItem::where('client_id', $this->id)->delete();
            foreach($clients as $d)
            {
                $cd = new ClientItem();
                $cd->client_id = $this->id;
                $cd->item_master_id = $d;
                $cd->save();
            }
        }

        $progress = $request->amazon;
        if($request->has('amazon') && $progress){
            ClientAmazonProgress::where('client_id', $this->id)->delete();
            foreach($progress as $d)
            {
                $cd = new ClientAmazonProgress();
                $cd->client_id = $this->id;
                $cd->amazon_progress_id = $d;
                $cd->save();
            }
        }
    }
}
