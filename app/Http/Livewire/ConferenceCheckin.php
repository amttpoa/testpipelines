<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ConferenceAttendee;
use App\Models\CourseAttendee;

class ConferenceCheckin extends Component
{
    use WithPagination;
    public $searchTerm;
    public $conference;



    public function clear()
    {
        $this->searchTerm = null;
    }
    public function checkin($id)
    {
        $conferenceAttendee = ConferenceAttendee::find($id);
        $conferenceAttendee->checked_in = true;
        $conferenceAttendee->checked_in_by_user_id = auth()->user()->id;
        $conferenceAttendee->checked_in_at = now();
        $conferenceAttendee->update();
    }

    public function render()
    {
        session(['checkinsearchTerm' => $this->searchTerm]);

        $searchTerm = $this->searchTerm;
        $conference = $this->conference;

        // dd($selectedAccount);

        $attendees = ConferenceAttendee::query()
            ->where('conference_id', $conference->id)
            // ->when($selectedAccount, function ($query) use ($selectedAccount) {
            //     $query->whereHas(
            //         'user',
            //         function ($query) use ($searchTerm) {
            //             return $query
            //                 ->where('name', 'like', '%' . $searchTerm . '%')
            //                 ->orWhere('email', 'like', '%' . $searchTerm . '%');
            //         }
            //     );
            // })

            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->whereHas(
                    'user',
                    function ($query) use ($searchTerm) {
                        return $query
                            ->where('name', 'like', '%' . $searchTerm . '%')
                            ->orWhere('email', 'like', '%' . $searchTerm . '%');
                    }
                );
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(10);


        return view('livewire.conference-checkin', compact('attendees'));
    }
}
