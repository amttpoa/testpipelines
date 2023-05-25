<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ConferenceHotelRequest;
use App\Exports\ConferenceHotelRequestsExport;

class ConferenceHotelRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Conference $conference)
    {
        return view('hotel-requests.index', compact('conference'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Conference $conference, Request $request)
    {
        if ($request->user_id) {
            $conferenceHotelRequest = new ConferenceHotelRequest;
            $conferenceHotelRequest->user_id = $request->user_id;
            $conference->conferenceHotelRequests()->save($conferenceHotelRequest);

            return redirect()->route('admin.conference-hotel-requests.edit', [$conference, $conferenceHotelRequest])->with('success', 'Hotel request created');
        } else {
            return redirect()->back()->with('success', 'No user selected');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ConferenceHotelRequest  $conferenceHotelRequest
     * @return \Illuminate\Http\Response
     */
    public function show(ConferenceHotelRequest $conferenceHotelRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ConferenceHotelRequest  $conferenceHotelRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(Conference $conference, ConferenceHotelRequest $conferenceHotelRequest)
    {
        return view('hotel-requests.edit', compact('conference', 'conferenceHotelRequest'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ConferenceHotelRequest  $conferenceHotelRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conference $conference, ConferenceHotelRequest $conferenceHotelRequest)
    {
        $conferenceHotelRequest->room_type = $request->room_type;
        $conferenceHotelRequest->roommate = $request->roommate;
        $conferenceHotelRequest->room = $request->room;
        $conferenceHotelRequest->start_date = $request->start_date;
        $conferenceHotelRequest->end_date = $request->end_date;
        $conferenceHotelRequest->comments = $request->comments;
        $conferenceHotelRequest->update();

        return redirect()->route('admin.conference-hotel-requests.index', $conference)->with('success', 'Hotel request updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ConferenceHotelRequest  $conferenceHotelRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conference $conference, ConferenceHotelRequest $conferenceHotelRequest)
    {
        $conferenceHotelRequest->delete();

        return redirect()->route('admin.conference-hotel-requests.index', $conference)->with('success', 'Hotel request deleted');
    }



    public function export(Request $request, Conference $conference)
    {

        $file = $conference->name . ' - Hotel Requests.xlsx';

        if ($request->view == 'web') {
            // $type = $request->type;
            // return view('vendor-registrations.export', compact('conference', 'type'));
        } else {
            return Excel::download(new ConferenceHotelRequestsExport($request, $conference), $file);
        }
    }
}
