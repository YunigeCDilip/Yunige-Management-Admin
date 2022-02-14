<?php

namespace App\Application\Services;

use App\Traits\ResponseTrait;
use App\Traits\CacheHelperTrait;
use App\Traits\AuthTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Service
{
    use ResponseTrait;
    use AuthTrait;
    use CacheHelperTrait;
    use AuthorizesRequests;
}
