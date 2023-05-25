<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }

    // public function profile()
    // {
    //     $profile = Profile::where('user_id', Auth::user()->id)->first();
    //     return view('site.profile', compact('profile'));
    // }

    // public function profilePatch(Request $request)
    // {
    //     $profile = Profile::where('user_id', Auth::user()->id)->first();

    //     $profile->title = $request->title;
    //     $profile->phone = $request->phone;
    //     $profile->birthday = $request->birthday;
    //     $profile->address = $request->address;
    //     $profile->city = $request->city;
    //     $profile->state = $request->state;
    //     $profile->zip = $request->zip;
    //     $profile->bio = $request->bio;
    //     // $profile->phone = $request->phone;

    //     $profile->update();

    //     return redirect()->route('profile')
    //         ->with('success', 'Your profile has been updated');
    // }

    // public function profileImageUpload(Request $request)
    // {

    //     // dd($request);
    //     $fileName = $request->image->getClientOriginalName();
    //     $fileExt = $request->image->getClientOriginalExtension();

    //     $file_name = pathinfo($fileName, PATHINFO_FILENAME);

    //     $newfileName = $file_name . "-" . now()->timestamp . "." . $fileExt;

    //     $filePath = $request->image->move(public_path('storage/profile'), $newfileName, 'public');
    //     if (auth()->user()->hasRole('Admin') && isset($request->user_id)) {
    //         $profile = Profile::where('user_id', $request->user_id)->first();
    //     } else {
    //         $profile = Profile::where('user_id', Auth::user()->id)->first();
    //     }
    //     $profile->image = $newfileName;
    //     $profile->update();

    //     return response()->json(['newfileName' => $newfileName, 'fileName' => $fileName, 'filePath' => $filePath]);
    // }
}
