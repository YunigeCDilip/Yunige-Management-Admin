<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ZoomMeeting;

use GuzzleHttp\Client;
use Log;

class migrateZoomMeeting extends Command
{
    public $client;
    public $jwt;
    public $headers;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:meeting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $record = $this->getZoomMeetingList();
        
        if (isset($record['data']) && $record['success']) {
            $data = $record['data'];
            $listData = isset($data['meetings']) ? $data['meetings'] : '';
            info($listData);

            foreach( $listData as $meetingData ){
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
        }


        return 0;
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

    private function getZoomMeetingList()
    {
        //$path = 'users/me/meetings';
        $path = 'users/me/meetings?type=upcoming';
        $url = config('services.zoom.base_url','');
        $this->jwt = $this->generateZoomToken();
        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([]),
            'verify' => false
        ];

        $response =  $this->client->get($url.$path, $body);
        //dd(json_decode($response->getBody(), true));

        return [
            'success' => $response->getStatusCode() === 200,
            'data'    => json_decode($response->getBody(), true),
        ];
    }

}
