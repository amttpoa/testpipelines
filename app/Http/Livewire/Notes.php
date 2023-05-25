<?php

namespace App\Http\Livewire;

use App\Models\Note;
use Livewire\Component;

class Notes extends Component
{
    public $note;
    public $subject_type;
    public $subject_id;

    protected $rules = [
        'note' => 'required',
    ];




    public function formSubmit()
    {

        $note = new Note();
        $note->subject_type = $this->subject_type;
        $note->subject_id = $this->subject_id;
        $note->user_id = auth()->user()->id;
        $note->note = $this->note;
        $note->save();

        // $this->success = 'Thank you for reaching out to us!';

        $this->clearFields();
    }

    private function clearFields()
    {
        $this->note = '';
    }

    public function delete($id)
    {
        Note::find($id)->delete();
    }

    public function render()
    {
        $notes = Note::where('subject_type', $this->subject_type)->where('subject_id', $this->subject_id)->orderBy('created_at', 'DESC')->get();
        return view('livewire.notes', compact('notes'));
    }
}
