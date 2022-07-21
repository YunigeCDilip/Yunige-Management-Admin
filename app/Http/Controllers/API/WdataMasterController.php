<?php

namespace App\Http\Controllers\API;

use App\Models\Shipper;
use App\Models\BrandMaster;
use App\Models\WdataStatus;
use App\Models\CustomBroker;
use App\Models\ItemCategory;
use App\Models\InboundStatus;
use App\Models\WdataCategory;
use App\Traits\ResponseTrait;
use App\Models\ShipmentMethod;
use App\Domains\WarehouseDomain;
use App\Constants\MessageResponse;
use App\Http\Controllers\Controller;
use App\Application\Services\UserService;
use App\Application\Services\DeliveryService;
use App\Application\Services\WarehouseDataService;

class WdataMasterController extends Controller
{
    use ResponseTrait;

    /**
     * @var $service
     */
    protected $service;
    protected $deliveryService;
    protected $userService;

    public function __construct( 
        WarehouseDataService $service,
        DeliveryService $deliveryService,
        UserService $userService,
    )
    {
        $this->service = $service;
        $this->deliveryService = $deliveryService;
        $this->userService = $userService;
    }

    /**
     * Required data to create wdata
     *
     * @return Response
     */
    public function index()
    {
        $delivery = json_decode($this->deliveryService->all()->getContent());
        $users = json_decode($this->userService->all()->getContent());
        $data['project_charges'] = $users->payload;
        $data['transportation_methods'] = ['sea','air'];
        $data['category_classifications'] = WdataCategory::where('active_status', true)->get();
        $data['shipping_companies'] = ShipmentMethod::select('id', 'name')->get();
        $data['custom_brokers'] = CustomBroker::select('id', 'name')->get();
        $data['arrival_progress'] = WdataStatus::select('id', 'name')->get();
        $data['arrival_places'] = $delivery->payload;
        $data['goods_receipt_progress'] = InboundStatus::select('id', 'name')->get();
        $data['labeling_status'] = WarehouseDomain::labelingStatus();
        $data['fnsku'] = ['必要','不要', '不明'];
        $data['work_instructions'] = WarehouseDomain::workInstructions();

        return $this->responseOk($data, MessageResponse::DATA_LOADED);
    }
}
