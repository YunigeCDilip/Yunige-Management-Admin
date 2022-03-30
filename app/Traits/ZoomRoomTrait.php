<?php
namespace App\Traits;

use Throwable;
use GuzzleHttp\Client;
use App\Models\ZoomRoom;
use Illuminate\Support\Facades\Log;

/**
 * trait ZoomRoomTrait
 */
trait ZoomRoomTrait
{
    public $client;
    public $jwt;
    public $headers;

    public function __construct()
    {
        $this->client = new Client();
        $this->jwt = $this->generateZoomToken();
        $this->headers = [
            'Authorization' => 'Bearer '.$this->jwt,
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];
    }
    public function generateZoomToken()
    {
        $key = config('services.zoom.api_key','');
        $secret = config('services.zoom.app_secret','');
        $payload = [
            'iss' => $key,
            'exp' => strtotime('+1 minute'),
        ];

        return \Firebase\JWT\JWT::encode($payload, $secret, 'HS256');
    }

    private function retrieveZoomUrl()
    {
        return config('services.zoom.base_url','');
    }

    public function toZoomTimeFormat(string $dateTime)
    {
        try {
            $date = new \DateTime($dateTime);

            return $date->format('Y-m-d\TH:i:s');
        } catch (\Exception $e) {
            Log::error('ZoomJWT->toZoomTimeFormat : '.$e->getMessage());

            return '';
        }
    }

    public function listZoomRooms() {
        $path = 'rooms';
        $url = $this->retrieveZoomUrl();
        $this->jwt = $this->generateZoomToken();
        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([]),
            'verify' => false
        ];

        $response =  $this->client->get($url.$path, $body);

        return [
            'success' => $response->getStatusCode() === 200,
            'data'    => json_decode($response->getBody(), true),
        ];
    }

    public function createZoomRoom($data)
    {
        $path = 'rooms';
        $url = $this->retrieveZoomUrl();

        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([
                'name' =>  $data['name'],
                'type' =>  $data['type'],
            ]),
            'verify' => false
        ];

        $response =  $this->client->post($url.$path, $body);

        return [
            'success' => $response->getStatusCode() === 201,
            'data'    => json_decode($response->getBody(), true),
        ];
    }

    public function update($id,$data)
    {
        $path = 'rooms/'.$id;
        //$path = 'accounts/7000953037/rooms/'.$id;
        $url = $this->retrieveZoomUrl();

        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([
                'name' =>  $data['name'],
            ]),
            'verify' => false
        ];

        $response =  $this->client->patch($url.$path, $body);

        return [
            'success' => $response->getStatusCode() === 204,
            'data'    => json_decode($response->getBody(), true),

        ];
    }
    /**
     * @param mixed $id
     * 
     * @return response
     */
    public function delete($id)
    {
        $path = 'rooms/'.$id;
        $url = $this->retrieveZoomUrl();
        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([]),
            'verify' => false

        ];

        $response =  $this->client->delete($url.$path, $body);

        return [
            'success' => $response->getStatusCode() === 204,
        ];
    }
    /**
     * @param mixed $id
     * 
     * @return response
     */
    public function start($id)
    {

    }
    
    /**
     * Return data to render datatable
     * 
     * @param mixed $request
     * 
     * @return mixed
     */
    public function datatable($request)
    {
        try {
            $columns = array(
                0 => 'name',
                1 => 'activation_code',
                2 => 'status',
                3 => 'created_at'
            );
            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
            $meetingLists = ZoomRoom::Search($request->search);
            $totalMeetingCount = $meetingLists->count();
            $meetings = $meetingLists->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = $totalMeetingCount;
            $tableContent = array();
            if (!empty($meetings)) {
                $meetingData = array();
                foreach ($meetings as $index => $meeting) {
                    $nestedData = array();
                    $nestedData['id'] = $meeting->id;
                    $nestedData['name'] = $meeting->name;
                    $nestedData['created_at'] = date('Y-m-d H:i A', strtotime($meeting->created_at));
                    $nestedData['status'] = $meeting->status;
                    $nestedData['activation_code'] = $meeting->activation_code;
                    $meetingData[] = $nestedData;
                }

                $tableContent = array(
                    "draw" => intval($request->input('draw')),
                    "recordsTotal" => $totalMeetingCount,
                    "recordsFiltered" => $totalFiltered,
                    "data" => $meetingData,
                );
            }
            return $tableContent;
            
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return [];
        }
    }
}