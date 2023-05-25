<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Course;
use Livewire\Component;
// use Mail;

class CourseCreate extends Component
{
    public $name;
    public $user_id;
    public $capacity;
    public $start_date;
    public $end_date;
    public $start_time;
    public $end_time;
    public $description;
    public $success;
    public $conference_id;

    protected $rules = [
        'name' => 'required',
        'capacity' => 'required',
    ];

    public function formSubmit()
    {
        $contact = $this->validate();
        // dd($contact);

        $course = new Course();
        $course->conference_id = $this->conference_id;
        $course->user_id = $this->user_id;
        $course->name = $this->name;
        $course->capacity = $this->capacity;
        $course->start_date = $this->start_date . ' ' . $this->start_time;
        $course->end_date = $this->start_date . ' ' . $this->end_time;
        $course->description = $this->description;
        $course->save();

        $this->success = 'Course Created';

        $this->clearFields();
    }

    private function clearFields()
    {
        $this->name = '';
        $this->capacity = '';
        $this->description = '';
    }

    public function render()
    {
        $instructors = User::role('Conference Instructor')->orderBy('name')->pluck('name', 'id');
        $courses = Course::where('conference_id', $this->conference_id)->orderBy('start_date')->get();
        return view('livewire.course-create', compact('courses', 'instructors'));
    }
}
