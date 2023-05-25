<?php

namespace App\Http\Livewire;

use App\Models\Course;
use Livewire\Component;
use App\Models\CourseTag;
use Livewire\WithPagination;

class ConferenceCourseSearch extends Component
{
    use WithPagination;
    public $searchTerm;
    public $conference;
    public $sort;
    public $tag = [];
    public $course_id = [];
    public $all_course_id = [];
    public $item;
    public $check_all;

    public function mount()
    {
        if (session()->has('coursesearchTerm')) {
            $this->searchTerm = session('coursesearchTerm');
        }
        if (session()->has('coursesort')) {
            $this->sort = session('coursesort');
        }
        if (session()->has('coursetag')) {
            $this->tag = session('coursetag');
        }
    }


    public function checkAll()
    {
        if ($this->check_all) {
            $this->course_id = $this->all_course_id;
        } else {
            $this->course_id = [];
        }
    }
    public function formSubmit()
    {
        $course_id = $this->course_id;
        $item = $this->item;


        // if ($item == 'View Rosters') {

        //     $courses = Course::where('id', $course->id)->get();
        //     return view('course-attendees.print-roster', compact('courses'));
        // }
        // if ($item == 'invoiced') {
        //     ConferenceAttendee::whereIn('id', $attendee_id)->update(['invoiced' => $not ? 0 : 1]);
        // }
        // if ($item == 'paid') {
        //     ConferenceAttendee::whereIn('id', $attendee_id)->update(['paid' => $not ? 0 : 1]);
        // }
        // if ($item == 'checked in') {
        //     ConferenceAttendee::whereIn('id', $attendee_id)->update(['checked_in' => $not ? 0 : 1]);
        // }
        // if ($item == 'completed') {
        //     ConferenceAttendee::whereIn('id', $attendee_id)->update(['completed' => $not ? 0 : 1]);
        // }

        // dd($mark_type);
    }


    public function clear()
    {
        $this->searchTerm = null;
        $this->sort = null;
        $this->tag = [];
    }

    public function render()
    {
        session(['coursesearchTerm' => $this->searchTerm]);
        session(['coursesort' => $this->sort]);
        session(['coursetag' => $this->tag]);

        $searchTerm = $this->searchTerm;
        $conference = $this->conference;
        $sort = $this->sort;
        $tag = $this->tag;

        $tags = CourseTag::orderBy('name')->get();

        $courses = Course::query()
            ->where('conference_id', $conference->id)
            ->when($tag, function ($query) use ($tag) {
                $query->whereHas('courseTags', function ($query) use ($tag) {
                    $query->whereIn('name', $tag);
                });
            })
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%');
            })
            ->when($sort == 'open', function ($query) use ($sort) {
                $query->orderBy('available');
            })
            ->when($sort == 'date', function ($query) use ($sort) {
                $query->orderBy('start_date')->orderBy('end_date');
            })
            ->orderBy('name')
            ->paginate(50);
        // ->through(function ($course) {
        //     $course->remaining = $course->capacity - $course->courseAttendees->count();
        //     return $course;
        // })->sortBy('remaining');

        $this->all_course_id = $courses->pluck('id');

        return view('livewire.conference-course-search', compact('courses', 'tags'));
    }
}
