<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ZoomMeeting;
use App\Models\ZoomRoom;

class HomeController extends Controller
{
    public function index()
    {
        $meeting = ZoomMeeting::where(['topic'=>'demo'])->first();
        // dd($meeting->topic);
        $rooms = ['test','test1'];
        return view('front.index',compact('meeting','rooms'));
        /*return view('front.index', [
            'rooms' => $rooms,
            'meeting' => $meeting
        ]);
        */
    }
}
