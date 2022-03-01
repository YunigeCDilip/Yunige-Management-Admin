<?php

namespace App\Application\Repositories;

use Illuminate\Database\DatabaseManager;
use App\Application\Contracts\RoleContract;

class RoleRepository implements RoleContract 
{
    /**
     * 
     * @var  DatabaseManager manager
     */
    protected $db;

    public function __construct(
        DatabaseManager $db
    ){
        $this->db = $db;
    }
}
