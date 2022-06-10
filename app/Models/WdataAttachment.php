<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class WdataAttachment extends Model
{
    use HasFactory;
    
    /**
    * Get the attachments extension.
    *
    * @return Attribute
    */
   protected function ext(): Attribute
   {
       return Attribute::make(
           get: fn ($value) => ($value == 'image/png' || $value == 'image/jpeg' || $value == 'image/jpg' || $value == 'image/gif') ? true : false,
       );
   }
   
   /**
    * BelongsTo relationships with wdata
    * @return BelongsTo
    */
   public function wdata(): BelongsTo
   {
       return $this->belongsTo(Wdata::class, 'wdata_id');
   }
}
