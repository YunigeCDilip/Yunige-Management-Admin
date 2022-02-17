<?php

namespace App\Application\Repositories;

use Illuminate\Database\DatabaseManager;
use App\Application\Contracts\WarehouseDataContract;

class WarehouseDataRepository implements WarehouseDataContract 
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
