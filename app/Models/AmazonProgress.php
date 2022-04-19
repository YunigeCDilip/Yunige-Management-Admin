<?php

namespace App\Models;

use App\Models\Models\AmazonProgressFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AmazonProgress extends Model
{
    use HasFactory;

    public function amazonProgress()
    {
        return $this->hasOne(ClientAmazonProgress::class, 'amazon_progress_id');
    }


    public function files()
    {
        return $this->hasMany(AmazonProgressFile::class, 'amazon_progress_id');
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
            return $query->where('name', 'LIKE', '%'.$search.'%')
                    ->orWhere('status', 'LIKE', '%'.$search.'%')
                    ->orWhere('pickup', 'LIKE', '%'.$search.'%')
                    ->orWhere('memo', 'LIKE', '%'.$search.'%')
                    ->orWhereRaw("IF(done = 1, 'Done', 'Not Done') like ?",[$search]);
        }
    }
}