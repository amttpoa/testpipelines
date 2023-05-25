<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ReimbursementUpload;
use Illuminate\Support\Facades\Storage;

class ReimbursementUploads extends Component
{
    use WithFileUploads;
    public $files = [];
    public $reimbursement_id;


    public function submit()
    {
        foreach ($this->files as $file) {

            $originalName = $file->getClientOriginalName();
            $fileName = $this->reimbursement_id . "-" . time() . "-" . $originalName;

            Storage::disk('s3')->putFileAs('reimbursements', $file, $fileName);

            $upload = new ReimbursementUpload;
            $upload->reimbursement_id = $this->reimbursement_id;
            $upload->user_id = auth()->user()->id;
            $upload->file_name = $fileName;
            $upload->file_original = $originalName;
            $upload->save();
        }
        $this->files = null;
    }

    public function delete($id)
    {
        ReimbursementUpload::find($id)->delete();
    }

    public function render()
    {
        $uploads = ReimbursementUpload::where('reimbursement_id', $this->reimbursement_id)->orderBy('created_at', 'ASC')->get();
        return view('livewire.reimbursement-uploads', compact('uploads'));
    }
}
