<?php

namespace App\Http\Controllers;

use App\Models\UploadFolder;
use Illuminate\Http\Request;

class UploadFolderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $folders = UploadFolder::orderBy('order')->get();
        return view('upload-folders.index', compact('folders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $restrictions = [
            '' => 'Available to all users',
            'Staff Only' => 'Staff Only',
            'Staff Instructors Only' => 'Staff Instructors Only',
            'Board of Directors Only' => 'Board of Directors Only',
        ];
        return view('upload-folders.create', compact('restrictions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $folder = new UploadFolder();
        $folder->name = $request->name;
        $folder->slug = $request->slug;
        $folder->description = $request->description;
        $folder->order = $request->order;
        $folder->restriction = $request->restriction;
        $folder->save();

        return redirect()->route('admin.upload-folders.index')->with('success', 'Upload Folder Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UploadFolder  $uploadFolder
     * @return \Illuminate\Http\Response
     */
    public function show(UploadFolder $uploadFolder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UploadFolder  $uploadFolder
     * @return \Illuminate\Http\Response
     */
    public function edit(UploadFolder $uploadFolder)
    {
        $restrictions = [
            '' => 'Available to all users',
            'Staff Only' => 'Staff Only',
            'Staff Instructors Only' => 'Staff Instructors Only',
            'Board of Directors Only' => 'Board of Directors Only',
        ];

        return view('upload-folders.edit', compact('uploadFolder', 'restrictions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UploadFolder  $uploadFolder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UploadFolder $uploadFolder)
    {
        $uploadFolder->name = $request->name;
        $uploadFolder->slug = $request->slug;
        $uploadFolder->description = $request->description;
        $uploadFolder->order = $request->order;
        $uploadFolder->restriction = $request->restriction;
        $uploadFolder->update();

        return redirect()->route('admin.upload-folders.index')->with('success', 'Upload Folder Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UploadFolder  $uploadFolder
     * @return \Illuminate\Http\Response
     */
    public function destroy(UploadFolder $uploadFolder)
    {
        //
    }
}
