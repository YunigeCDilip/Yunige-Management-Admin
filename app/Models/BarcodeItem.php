<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BarcodeItem extends Model
{
    use HasFactory;

    /**
     * @param string $value
     *
     * @return Builder
     */
    public function scopeWhereBarcode(Builder $query, $value)
    {
        return $query->where('barcode', $value);
    }
}
