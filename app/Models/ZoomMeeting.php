<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ZoomMeeting extends Model
{
    use HasFactory;
    //use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'meeting_id',
        'host_id',
        'topic',
        'type',
        'start_time',
        'duration',
        'timezone',
        'agenda',
        'join_url',
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
            return $query->where('topic', 'LIKE', '%'.$search.'%')
                    ->orWhere('meeting_id', 'LIKE', '%'.$search.'%')
                    ->orWhereRaw("IF(upcoming = 1, 'Up Coming', 'Previous') like ?",[$search])
                    ->orWhereDate('start_time', $search);
        }
    }
}
