<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Staff;
use App\Models\StaffSection;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $staffs = Staff::whereHas('staffSection', function ($query) {
        //     $query->orderBy('order');
        // })->with('staffSection')->orderBy('staffSection.order')->orderBy('order')->get();

        // $staffs = Staff::whereHas('staffSection', function ($query) {
        //     $query->orderBy('order');
        // })->orderBy('order')->get();

        $staffs = Staff::orderBy('order')
            ->get()
            ->groupBy(function ($q) {
                return $q->staffSection->name;
            });

        // $trainingCourses = TrainingCourse::where('venue_id', $venue->id)
        //     ->get()
        //     ->groupBy(function ($training) {
        //         return $training->training->name;
        //     });
        // dd($staffs);

        return view('staff.index', compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $sections = [
        //     'Board of Directors' => 'Board of Directors',
        //     'Red Team' => 'Red Team',
        // ];
        $sections = StaffSection::orderBy('order')->pluck('name', 'id');
        $users = User::role(['Conference Instructor', 'Staff Instructor', 'Board of Directors'])->orderBy('name')->pluck('name', 'id');

        return view('staff.create', compact('sections', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $staff = new Staff();
        $staff->staff_section_id = $request->staff_section_id;
        $staff->user_id = $request->user_id;
        $staff->title = $request->title;
        $staff->order = $request->order;
        $staff->save();

        return redirect()->route('admin.staffs.index')->with('success', 'Staff member added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Staff $staff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(Staff $staff)
    {
        // $sections = [
        //     'Board of Directors' => 'Board of Directors',
        //     'Red Team' => 'Red Team',
        // ];
        $sections = StaffSection::orderBy('order')->pluck('name', 'id');
        $users = User::role(['Conference Instructor', 'Staff Instructor', 'Board of Directors'])->orderBy('name')->pluck('name', 'id');

        return view('staff.edit', compact('staff', 'sections', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Staff $staff)
    {
        $staff->staff_section_id = $request->staff_section_id;
        $staff->user_id = $request->user_id;
        $staff->title = $request->title;
        $staff->order = $request->order;
        $staff->update();

        return redirect()->route('admin.staffs.index')->with('success', 'Staff member updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->route('admin.staffs.index')->with('success', 'Staff member deleted');
    }
}
