<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\EventAttendee;

class EventAttendeeSearch extends Component
{
    public $event;
    public $attendee_id;
    public $all_attendee_id;
    public $check_all;
    public $item;
    public $not;

    public function checkAll()
    {
        if ($this->check_all) {
            $this->attendee_id = $this->all_attendee_id;
        } else {
            $this->attendee_id = [];
        }
    }

    public function formSubmit()
    {
        $attendee_id = $this->attendee_id;
        $item = $this->item;
        $not = $this->not;

        if ($item == 'checked in') {
            EventAttendee::whereIn('id', $attendee_id)->update(['checked_in' => $not ? 0 : 1]);
        }

        // dd($mark_type);
    }

    public function render()
    {
        $event = $this->event;
        $attendee_id = $this->attendee_id;

        $eventAttendees = EventAttendee::where('event_id', $event->id)->get();

        $this->all_attendee_id = $event->eventAttendees->pluck('id');



        return view('livewire.event-attendee-search', compact('event', 'eventAttendees'));
    }
}
