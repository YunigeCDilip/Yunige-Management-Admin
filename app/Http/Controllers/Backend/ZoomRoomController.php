<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ZoomMeeting;
use App\Models\ZoomRoom;
use App\Traits\ZoomRoomTrait;

use Illuminate\Http\Request;


class ZoomRoomController extends Controller
{
    use ZoomRoomTrait;

    public function listRooms(Request $request)
    {
        $rooms = $this->listZoomRooms();
        return view('admin.rooms.list', compact('rooms'));

    }

    public function createRoom(Request $request)
    {
        return view('admin.rooms.create');
    }

    public function saveRoom(Request $request) {
        $data = $this->createZoomRoom($request->all());
        
        if (isset($data['data']) && $data['success']) {
            $roomData = isset($data['data']) ? $data['data'] : '';
            $zoomRoom = new ZoomRoom();
            $zoomRoom->room_id = isset($roomData['id']) ? $roomData['id'] : '';
            $zoomRoom->name = isset($roomData['name']) ? $roomData['name'] : '';
            $zoomRoom->location_id = isset($roomData['location_id']) ? $roomData['location_id'] : '';
            $zoomRoom->activation_code = isset($roomData['activation_code']) ? $roomData['activation_code'] : '';
            $zoomRoom->status = isset($roomData['status']) ? $roomData['status'] : '';
            
            $zoomRoom->save();
            return redirect()->route('admin.rooms.list');
        }
        return redirect()->url('/meeting');
    }
}
