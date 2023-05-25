<?php

namespace App\Http\Livewire;

use App\Models\Upload;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class FilesUpload extends Component
{
    use WithFileUploads;
    public $files = [];
    public $title;
    public $folder;
    public $main_id;
    public $uploadNum;


    // public $workshop;
    public $uploads = [];


    // public function mount($workshop)
    // {
    //     $this->main_id = $workshop->id;
    // }

    public function mount()
    {
        // dd($this->endpoint);
    }


    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submit()
    {

        // dd($this->files);
        foreach ($this->files as $file) {


            $originalName = $file->getClientOriginalName();
            $fileName = $this->main_id . "-" . time() . "-" . $originalName;

            // dd($this->folder);

            Storage::disk('s3')->putFileAs($this->folder, $file, $fileName);


            $uploadLink = Storage::disk('s3')->url($this->folder . '/' . $fileName);

            $this->emit('gotcomment' . $this->uploadNum, $uploadLink);
        }

        $this->files = null;

        // $this->reset();
        // session()->flash('message', 'File successfully Uploaded.');

        return response()->json(['fileName' => $fileName]);
    }

    public function delete($index, $id)
    {
        // Upload::find($id)->delete();
        // $this->emit('removeUpload' . $this->uploadNum, $index);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function render()
    {
        return view('livewire.files-upload');
    }
}
