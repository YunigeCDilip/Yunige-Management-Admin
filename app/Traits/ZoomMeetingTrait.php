<?php
namespace App\Traits;

use Throwable;
use GuzzleHttp\Client;
use App\Models\ZoomMeeting;
use Illuminate\Support\Facades\Log;

/**
 * trait ZoomMeetingTrait
 */
trait ZoomMeetingTrait
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

    public function create($data)
    {
        $path = 'users/me/meetings';
        $url = $this->retrieveZoomUrl();

        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([
                'topic'      => $data['topic'],
                'type'       => self::MEETING_TYPE_SCHEDULE,
                'start_time' => $this->toZoomTimeFormat($data['start_time']),
                'duration'   => $data['duration'],
                'agenda'     => (! empty($data['agenda'])) ? $data['agenda'] : null,
                'timezone'     => 'Asia/Tokyo',
                'settings'   => [
                    'host_video'        => ($data['host_video'] == "1") ? true : false,
                    'participant_video' => ($data['participant_video'] == "1") ? true : false,
                    'waiting_room'      => true,
                ],
            ]),
            'verify' => false
        ];

        $response =  $this->client->post($url.$path, $body);

        return [
            'success' => $response->getStatusCode() === 201,
            'data'    => json_decode($response->getBody(), true),
        ];
    }

    public function update($id, $data)
    {
        $path = 'meetings/'.$id;
        $url = $this->retrieveZoomUrl();

        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([
                'topic'      => $data['topic'],
                'type'       => self::MEETING_TYPE_SCHEDULE,
                'start_time' => $this->toZoomTimeFormat($data['start_time']),
                'duration'   => $data['duration'],
                'agenda'     => (! empty($data['agenda'])) ? $data['agenda'] : null,
                'timezone'     => 'Asia/Tokyo',
                'settings'   => [
                    'host_video'        => ($data['host_video'] == "1") ? true : false,
                    'participant_video' => ($data['participant_video'] == "1") ? true : false,
                    'waiting_room'      => true,
                ],
            ]),
            'verify' => false
        ];
        $response =  $this->client->patch($url.$path, $body);

        return [
            'success' => $response->getStatusCode() === 204,
            'data'    => json_decode($response->getBody(), true),
        ];
    }

    public function get($id)
    {
        //dd($id);
        $path = 'meetings/'.$id;
        $url = $this->retrieveZoomUrl();
        $this->jwt = $this->generateZoomToken();
        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([]),
            'verify' => false

        ];

        $response =  $this->client->get($url.$path, $body);

        return [
            'success' => $response->getStatusCode() === 204,
            'data'    => json_decode($response->getBody(), true),
        ];
    }

    public function lists()
    {
        $path = 'users/me/meetings?type=upcoming';
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
    public function meetingLists()
    {
        $path = 'users/me/meetings?page_size=300';
        //$path = 'users/me/meetings?type=scheduled';
        //$path = 'users/me/meetings?type=upcoming';
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

    /**
     * @param string $id
     * 
     * @return bool[]
     */
    public function delete($id)
    {
        $path = 'meetings/'.$id;
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
    public function participant($meetingId)
    {
        //$path = 'metrics/meetings/'.$meetingId.'/participants';
        $path = 'past_meetings/'.$meetingId.'/participants';
        $url = $this->retrieveZoomUrl();
        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([]),
            'verify' => false

        ];
        //dd($url.$path,$body ); 97213775180

        $response =  $this->client->request('GET',$url.$path, $body);
        
        return $data = json_decode($response->getBody());

    }

    /*
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
    */

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
                0 => 'topic',
                1 => 'meeting_id',
                2 => 'start_time',
                3 => 'upcoming'
            );
            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
            $meetingLists = ZoomMeeting::Search($request->search);
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
                    $nestedData['topic'] = $meeting->topic;
                    $nestedData['start_time'] = date('Y-m-d H:i A', strtotime($meeting->start_time));
                    $nestedData['upcoming'] = $meeting->upcoming;
                    $nestedData['meeting_id'] = $meeting->meeting_id;
                    $nestedData['join_url'] = $meeting->join_url;
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