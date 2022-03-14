<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ZoomMeeting;
use App\Traits\ZoomMeetingTrait;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    use ZoomMeetingTrait;

    const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;

    public function list(Request $request)
    {
        $meetings = $this->lists();

        return view('admin.meetings.list', compact('meetings'));
    }

    public function createMeet(Request $request)
    {
        return view('admin.meetings.create');
    }

    public function show($id)
    {
        $meeting = $this->get($id);

        return view('admin.meetings.index', compact('meeting'));
    }

    public function store(Request $request)
    {
        $data = $this->create($request->all());
        
        if (isset($data['data']) && $data['success']) {
            $meetingData = isset($data['data']) ? $data['data'] : '';
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
            return redirect()->route('admin.meetings.index');
        }
    }

    public function updateMeeting($id, Request $request)
    {
        //dd($id);
        // $this->update($id, $request->all());

        return redirect()->route('admin.meetings.update');
    }

    public function destroy(ZoomMeeting $meeting)
    {
        //dd($meeting);
        $this->delete($meeting->id);

        return $this->sendSuccess('Meeting deleted successfully.');
    }
    public function participantList($id)
    {
        $data = $this->participant($id);

        return view('meetings.participants', [
            'participants' => !empty($data) ? $data->participants : '',
        ]);
    }

    public function listRooms(Request $request)
    {
        $rooms = $this->listZoomRooms();
        return view('admin.meetings.roomList', compact('rooms'));

    }

    public function createRoom(Request $request)
    {
        return view('admin.meetings.createRoom');
    }

    public function saveRoom(Request $request) {
        $data = $this->createZoomRoom($request->all());
        dd($data);
        return redirect()->url('/meeting');
    }
}
