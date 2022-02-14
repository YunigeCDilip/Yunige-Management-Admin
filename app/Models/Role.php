<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Builder;

class Role extends SpatieRole
{
    protected $table = 'roles';

    /**
     * @param string $value
     *
     * @return Builder
     */
    public function scopeSearch(Builder $query, $value)
    {
        return $query->where('name', 'LIKE', '%' . $value . '%')
            ->orWhere('created_at', 'LIKE', '%' . $value . '%');
    }
}
