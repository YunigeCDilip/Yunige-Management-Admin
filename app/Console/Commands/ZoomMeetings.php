<?php

namespace App\Console\Commands;
use App\Models\ZoomMeeting;
use GuzzleHttp\Client;
use Log;

use Illuminate\Console\Command;

class ZoomMeetings extends Command
{
    public $client;
    public $jwt;
    public $headers;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zoom:meeting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new zoom meeting every day';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->client = new Client();
        $this->jwt = $this->generateZoomToken();
        $this->headers = [
            'Authorization' => 'Bearer '.$this->jwt,
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        info($this->createNewZoomMeeting());
        $record = $this->createNewZoomMeeting();
        if (isset($record['data']) && $record['success']) {
            $meetingData = isset($record['data']) ? $record['data'] : '';
            $meeting = new ZoomMeeting();
            $meeting->meeting_id = isset($meetingData['id']) ? $meetingData['id'] : '';
            $meeting->host_id = isset($meetingData['host_id']) ? $meetingData['host_id'] : '';
            $meeting->host_email = isset($meetingData['host_email']) ? $meetingData['host_email'] : '';
            $meeting->topic = isset($meetingData['topic']) ? $meetingData['topic'] : '';
            $meeting->type = isset($meetingData['type']) ? $meetingData['type'] : '';
            $meeting->start_time = isset($meetingData['start_time']) ? $meetingData['start_time'] : '';
            $meeting->duration = isset($meetingData['duration']) ? $meetingData['duration'] : '';
            $meeting->timezone = isset($meetingData['timezone']) ? $meetingData['timezone'] : '';
            $meeting->start_url = isset($meetingData['start_url']) ? $meetingData['start_url'] : '';
            $meeting->join_url = isset($meetingData['join_url']) ? $meetingData['join_url'] : '';
            $meeting->password = isset($meetingData['password']) ? $meetingData['password'] : '';
            $meeting->save();
        }
        return 0;
    }
    private function createNewZoomMeeting()
    {
        $data =  ZoomMeeting::orderBy('created_at', 'desc')->first();

        $path = 'users/me/meetings';
        $url = config('services.zoom.base_url','');

        $date = date('Y-m-d');
        $dateTime = date('Y-m-d', strtotime('+1 day', strtotime($date))) .' 08:30:30';


        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([
                'topic'      => $data['topic'],
                'type'       => '2',
                'start_time' => $this->toZoomTimeFormat($dateTime),
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


        return $data;

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
   

}
