<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Hotel;
use App\Models\Venue;
use App\Models\Course;
use App\Models\Conference;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $venues = Venue::orderBy('name')->get();

        return view('venues.index', compact('venues'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('venues.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        $venue = Venue::create($data);

        return redirect()->route('admin.venues.index')->with('success', 'Venue Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Venue $venue)
    {
        // dd(Conference::where('start_date', '>', now())->orderBy('start_date')->get('id')->first()->id);
        $courses = Course::where('conference_id', Conference::where('start_date', '>', now())->orderBy('start_date')->get('id')->first()->id)
            ->where('venue_id', $venue->id)
            ->orderBy('start_date')
            ->get();
        // dd($courses);
        return view('venues.show', compact('venue', 'courses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(Venue $venue)
    {
        $hotels = Hotel::orderBy('name')->pluck('name', 'id');
        $hotelsAll = Hotel::orderBy('name')->get();
        $users = User::role('Staff')->orderBy('name')->get()->pluck('name', 'id');
        return view('venues.edit', compact('venue', 'hotels', 'hotelsAll', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Venue $venue)
    {
        $data = $request->except(['hotel', 'image']);
        $data['slug'] = Str::slug($request->name);

        $venue->update($data);

        $venue->hotels()->sync($request->hotel);

        if ($request->image) {

            $fileName = $request->image->getClientOriginalName();
            $fileExt = $request->image->getClientOriginalExtension();
            $file_name = pathinfo($fileName, PATHINFO_FILENAME);
            $newfileName = $file_name . "-" . now()->timestamp . "." . $fileExt;

            $filePath = $request->image->move(public_path('storage/venues'), $newfileName, 'public');

            $venue->image = $newfileName;
            $venue->update();


            // dd($newfileName);
            // $resize = Image::make($request->image)->resize(800, 800, function ($constraint) {
            //     $constraint->aspectRatio();
            //     $constraint->upsize();
            // })->stream()->detach();

            // Storage::disk('s3')->put('vendor-logos/' . $newfileName, $resize);

            //$image is the temporary path of your image (/tmp/something)
            // $image = $request->image;

            // //Create a Image object with the tmp path
            // $resized_img = Image::make($image);


            // //Do what you want and save your modified image on the same temporary path as the original image.
            // $resized_img->resize(800, 800, function ($constraint) {
            //     $constraint->aspectRatio();
            //     $constraint->upsize();
            // })->save($image);




            // dd($resized_img);
            // $filePath = $request->image->move(public_path('storage/venues'), $newfileName, 'public');

            //Upload your image on your bucket and get the final path of your image
            // $path = $image->storeAs(
            //     'venues',
            //     $newfileName,
            //     'public'
            // );



            // $imagePath = $resize->storeAs(
            //     'venues',
            //     $request->file('image')->getClientOriginalName(),
            //     'public'
            // );

            // dd($imagePath);

            // $image = Image::make(public_path("storage/{$imagePath}"))->fit(500, 500);
            // $image->save();

            // $profile->image = $imagePath;
        }

        return redirect()->route('admin.venues.index')->with('success', 'Venue Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venue $venue)
    {
        //
    }
}
