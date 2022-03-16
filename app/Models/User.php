<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'phone',
        'active_status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'active_status' => 'boolean',
    ];

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeFilterSuperAdmin(Builder $query){
        $query->where('is_super_admin', false);
    }

    /**
     * @param Builder $query
     * @param Builder $search
     *
     * @return Builder
     */
    public function scopeFilteredByEmail(Builder $query, $search){
        if($search != ''){
            $query->where('email', $search);
        }
    }

    /**
     * @param Builder $query
     * @param Builder $search
     *
     * @return Builder
     */
    public function scopeFilteredByActiveStatus(Builder $query, $search){
        if($search != ''){
            return $query->where('active_status',$search);
        }
    }

    /**
     * @param Builder $query
     * @param Builder $search
     *
     * @return Builder
     */
    public function scopeFilteredByCreatedDate(Builder $query, $search){
        if($search != ''){
            $query->where('created_at', '<=', $search);
        }
    }

    /**
     * @param Builder $query
     * @param Builder $date1
     * @param Builder $date2
     *
     * @return Builder
     */
    public function scopeFilterByDateRange(Builder $query, $date1, $date2){
        if($date1 != '' && $date2 != ''){
            if($date1 > $date2){
                $query->where('created_at', '>=', $date2)->where('created_at', '<=', $date1);
            }else if($date2 > $date1){
                $query->where('created_at', '>=', $date1)->whereDate('created_at', '<=', $date2);
            }else{
                $query->where('created_at', '<=', $date2);
            }
        }
    }

    /**
     * @param Builder $query
     * @param Builder $search
     *
     * @return Builder
     */
    public function scopeFilteredByName(Builder $query, $search){
        if($search != ''){
            $query->where('name', 'LIKE', '%'.$search.'%');
        }
    }

    /**
     * @param Builder $query
     * @param Builder $search
     *
     * @return Builder
     */
    public function scopeFilterByGlobalSearch(Builder $query, $search){
        if($search != ''){
            return $query->where('email', 'LIKE', '%'.$search.'%')
                    ->orWhere('name', 'LIKE', '%'.$search.'%')
                    ->orWhereRaw("IF(active_status = 1, 'Active', 'InActive') like ?",[$search])
                    ->orWhereDate('created_at', $search);
        }
    }
}
