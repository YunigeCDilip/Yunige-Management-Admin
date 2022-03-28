<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ZoomMeeting;
use App\Models\ZoomRoom;
use App\Traits\ZoomMeetingTrait;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    use ZoomMeetingTrait;

    const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;

    /**
     * @param Request $request
     * 
     * @return view
     */
    public function list(Request $request)
    {
        if(!$request->ajax()){
            $data['title'] = trans('zoom.all_meeting');
            $data['menu'] = trans('zoom.all_meeting');
            $data['subMenu'] = trans('actions.lists');

            return view('admin.meetings.list', $data);
        }

        $data = $this->datatable($request);

        return $data;
    }

    public function meetingList(Request $request)
    {
        //$meeting1 = ZoomMeeting::latest()->paginate(20);
        //dd($meeting1);
        $meetings = $this->meetingLists();

        return view('admin.meetings.list', compact('meetings'));
    }

    public function createMeet(Request $request)
    {
        return view('admin.meetings.create');
    }

    public function show($id)
    {
        //$meeting = $this->get($id);
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
            return redirect()->route('admin.meetings.list');
        }
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * 
     * @return Response
     */
    public function edit(ZoomMeeting $id)
    {
        $data = ZoomMeeting::find($id);
        $meetingData = $data[0];
        return view('admin.meetings.edit',compact('meetingData'));


    }

    public function updateMeeting($id, Request $request)
    {
        $data = ZoomMeeting::find($id);
       //dd($request->all());

        $data->update($request->all());
        $meetingId = $data->meeting_id;


        $updateMeeting = $this->update($meetingId, $request->all());


        return redirect()->route('admin.meetings.list');
    }

    /**
     * @param mixed $id
     * 
     * @return Response
     */
    public function destroy($id)
    {
        $meeting = ZoomMeeting::find($id);
        $response = $this->delete($meeting->meeting_id);
        if($response['success']){
            ZoomMeeting::find($id)->delete();
            return redirect()->route('admin.meetings.list');
        }

    }
    public function participantList($id)
    {
        $data = $this->participant($id);

        return view('meetings.participants', [
            'participants' => !empty($data) ? $data->participants : '',
        ]);
    }
}
