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

    /**
     * Lists all rooms
     * @param Request $request
     * 
     * @return View|Mixed
     */
    public function listRooms(Request $request)
    {
        if(!$request->ajax()){
            $data['title'] = trans('zoom.all_rooms');
            $data['menu'] = trans('zoom.all_rooms');
            $data['subMenu'] = trans('actions.lists');

            return view('admin.rooms.list', $data);
        }

        $data = $this->datatable($request);

        return $data;
    }

    public function createRoom(Request $request)
    {
        return view('admin.rooms.create');
    }

    /**
     * @param Request $request
     * 
     * @return [type]
     */
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

    /**
     * @param mixed $id
     * 
     * @return Response
     */
    public function edit($id)
    {
        $roomData = ZoomRoom::find($id);
        //$roomData = $data[0];
        return view('admin.rooms.edit',compact('roomData'));

    }
    public function updateRoom($id, Request $request)
    {
        $data = ZoomRoom::find($id);
        $roomId = $data->room_id;
        $updateRoom = $this->update($roomId, $request->all());
        dd($updateRoom);
        $data->update($request->all());
        return redirect()->route('admin.rooms.list');
    }
    public function destroy($id)
    {
        $room = ZoomRoom::find($id);
        $response = $this->delete($room->room_id);
        if($response['success']){
            ZoomRoom::find($id)->delete();
           // return $this->sendSuccess('Meeting deleted successfully.');
            return redirect()->route('admin.rooms.list');

        }

    }
}
