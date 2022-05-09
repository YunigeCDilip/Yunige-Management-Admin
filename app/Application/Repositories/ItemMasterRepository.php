<?php

namespace App\Application\Repositories;

use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use App\Application\Contracts\ItemMasterContract;
use Throwable;

class ItemMasterRepository implements ItemMasterContract 
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

    /**
     * Return required data for view.
     *
     * @return  Response
     */
    public function index()
    {
        try {
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
        }
    }

    /**
     * Return all active data for view.
     *
     * @return  Response
     */
    public function all()
    {
        try {
        } catch (Throwable $e) {
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return  Response
     */
    public function store($request)
    {
        try {
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return  Response
     */
    public function edit($id)
    {
        try {

        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return  Response
     */
    public function update($request, $id)
    {
        try {
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return  Response
     */
    public function destroy($request, $id)
    {
        try {
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
        }
    }
}
