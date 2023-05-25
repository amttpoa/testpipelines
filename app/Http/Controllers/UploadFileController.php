<?php

namespace App\Http\Controllers;

use App\Models\UploadFile;
use App\Models\UploadFolder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $folders = UploadFolder::orderBy('order')->get();
        return view('upload-files.index', compact('folders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $folders = UploadFolder::orderBy('order')->get()->pluck('name', 'id');
        return view('upload-files.create', compact('folders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $originalName = $request->file->getClientOriginalName();
        $fileName = "OTOA-" . time() . "-" . $originalName;

        Storage::disk('s3')->putFileAs('uploads/share', $request->file, $fileName);

        $upload = new UploadFile;
        $upload->user_id = auth()->user()->id;
        $upload->name = $request->name ? $request->name : $fileName;
        $upload->description = $request->description;
        $upload->upload_folder_id = $request->upload_folder_id;
        $upload->order = $request->order;
        $upload->file_name = $fileName;
        $upload->file_original = $originalName;
        $upload->file_ext = strtolower($request->file->extension());
        $upload->size = $request->file->getSize();
        $upload->save();

        return redirect()->route('admin.upload-files.index')->with('success', 'File Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UploadFile  $uploadFile
     * @return \Illuminate\Http\Response
     */
    public function show(UploadFile $uploadFile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UploadFile  $uploadFile
     * @return \Illuminate\Http\Response
     */
    public function edit(UploadFile $uploadFile)
    {
        $folders = UploadFolder::orderBy('order')->get()->pluck('name', 'id');
        return view('upload-files.edit', compact('folders', 'uploadFile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UploadFile  $uploadFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UploadFile $uploadFile)
    {
        $uploadFile->user_id = auth()->user()->id;
        $uploadFile->name = $request->name;
        $uploadFile->description = $request->description;
        $uploadFile->upload_folder_id = $request->upload_folder_id;
        $uploadFile->order = $request->order;
        $uploadFile->save();
        return redirect()->route('admin.upload-files.index')->with('success', 'File Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UploadFile  $uploadFile
     * @return \Illuminate\Http\Response
     */
    public function destroy(UploadFile $uploadFile)
    {
        $uploadFile->delete();
        return redirect()->route('admin.upload-files.index')->with('success', 'File Deleted');
    }
}
