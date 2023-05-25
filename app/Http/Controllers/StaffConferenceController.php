<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Course;
use App\Models\Conference;
use Illuminate\Http\Request;
use App\Models\Reimbursement;
use App\Models\ReimbursementItem;
use App\Models\ReimbursementMeal;
use Illuminate\Support\Facades\DB;
use App\Models\ConferenceHotelRequest;

class StaffConferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conferences = Conference::whereHas('courses', function ($query) {

            $query->where(function ($q) {
                $q->where('user_id', auth()->user()->id)
                    ->orWhere(
                        function ($q2) {
                            $q2->whereIn('id', DB::table('course_user')->where('user_id', auth()->user()->id)->pluck('course_id'));
                        }
                    );
            });
        })
            ->orderBy('start_date', 'DESC')
            // ->orWhereHas('courses', function ($query) {
            //     return $query->where('user_id', 2);
            // })
            ->get()
            ->map(function ($conference) {
                $conference->courses->map(function ($course) use ($conference) {
                    $course->sub_instructor_count = $course->users()->where('user_id', auth()->user()->id)->count();
                    return $course;
                });
                $conference->sub_instructor_count = $conference->courses->sum('sub_instructor_count');
                return $conference;
            });

        // dd($conferences);

        $courses = Course::where('user_id', auth()->user()->id)
            ->orderBy('conference_id', 'DESC')
            ->orderBy('start_date')
            ->get()
            ->groupBy(function ($e) {
                return $e->conference->name;
            });


        return view('site.dashboard.staff.conferences.index', compact('conferences', 'courses'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Conference $conference)
    {
        // $courses = Course::where('user_id', auth()->user()->id)

        // ->when($contractNoSpeaker, function ($query) {
        //     $query->where(function ($q) {
        //         $q->where('user_id', null)
        //             ->orWhere('user_id', 0);
        //     });
        // })

        $courses = Course::where(function ($query) {
            $query->where('user_id', auth()->user()->id)
                ->orWhere(
                    function ($q) {
                        $q->whereIn('id', DB::table('course_user')->where('user_id', auth()->user()->id)->pluck('course_id'));
                    }
                );
        })
            ->where('conference_id', $conference->id)
            ->orderBy('start_date')
            ->get();

        // ->where('conference_id', $conference->id)
        // ->orderBy('start_date')
        // ->get();
        return view('site.dashboard.staff.conferences.show', compact('conference', 'courses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function hotelRequest(Conference $conference)
    {
        return view('site.dashboard.staff.conferences.hotel-request', compact('conference'));
    }

    public function hotelRequestPost(Request $request, Conference $conference)
    {
        $hotel = new ConferenceHotelRequest();
        $hotel->conference_id = $conference->id;
        $hotel->user_id = auth()->user()->id;
        $hotel->room_type = $request->room_type;
        $hotel->roommate = $request->roommate;
        if ($hotel->room_type != 'No Room') {
            $hotel->start_date = $request->start_date;
            $hotel->end_date = $request->end_date;
        }
        $hotel->comments = $request->comments;
        $hotel->save();

        return redirect()->route('dashboard')->with('success', 'Thank you for submitting your hotel request');
    }

    public function hotelEdit(Conference $conference)
    {
        return view('site.dashboard.staff.conferences.hotel-edit', compact('conference'));
    }
    public function hotelEditPost(Request $request, Conference $conference)
    {
        $hotel = ConferenceHotelRequest::where('user_id', auth()->user()->id)->where('conference_id', $conference->id)->first();
        $hotel->room_type = $request->room_type;
        $hotel->roommate = $request->roommate;
        if ($hotel->room_type != 'No Room') {
            $hotel->start_date = $request->start_date;
            $hotel->end_date = $request->end_date;
        }
        $hotel->comments = $request->comments;
        $hotel->update();

        return redirect()->route('dashboard')->with('success', 'You have updated your hotel request');
    }

    public function reimbursement(Conference $conference)
    {
        $reimbursement = Reimbursement::where('conference_id', $conference->id)->where('user_id', auth()->user()->id)->first();
        $page = Page::find(15);

        if (!$reimbursement) {
            $reimbursement = new Reimbursement;
            $reimbursement->conference_id = $conference->id;
            $reimbursement->user_id = auth()->user()->id;
            $reimbursement->status = 'Open';
            $reimbursement->save();
        }

        $meals = [
            [
                0,
                0,
                $reimbursement->reimbursementMeals->where('day', 1)->where('meal', 3)->first() ? $reimbursement->reimbursementMeals->where('day', 1)->where('meal', 3)->first()->price : ''
            ],
            [
                $reimbursement->reimbursementMeals->where('day', 2)->where('meal', 1)->first() ? $reimbursement->reimbursementMeals->where('day', 2)->where('meal', 1)->first()->price : '',
                $reimbursement->reimbursementMeals->where('day', 2)->where('meal', 2)->first() ? $reimbursement->reimbursementMeals->where('day', 2)->where('meal', 2)->first()->price : '',
                $reimbursement->reimbursementMeals->where('day', 2)->where('meal', 3)->first() ? $reimbursement->reimbursementMeals->where('day', 2)->where('meal', 3)->first()->price : ''
            ],
            [
                $reimbursement->reimbursementMeals->where('day', 3)->where('meal', 1)->first() ? $reimbursement->reimbursementMeals->where('day', 3)->where('meal', 1)->first()->price : '',
                $reimbursement->reimbursementMeals->where('day', 3)->where('meal', 2)->first() ? $reimbursement->reimbursementMeals->where('day', 3)->where('meal', 2)->first()->price : '',
                $reimbursement->reimbursementMeals->where('day', 3)->where('meal', 3)->first() ? $reimbursement->reimbursementMeals->where('day', 3)->where('meal', 3)->first()->price : ''
            ],
            [
                $reimbursement->reimbursementMeals->where('day', 4)->where('meal', 1)->first() ? $reimbursement->reimbursementMeals->where('day', 4)->where('meal', 1)->first()->price : '',
                $reimbursement->reimbursementMeals->where('day', 4)->where('meal', 2)->first() ? $reimbursement->reimbursementMeals->where('day', 4)->where('meal', 2)->first()->price : '',
                $reimbursement->reimbursementMeals->where('day', 4)->where('meal', 3)->first() ? $reimbursement->reimbursementMeals->where('day', 4)->where('meal', 3)->first()->price : ''
            ],
            [
                $reimbursement->reimbursementMeals->where('day', 5)->where('meal', 1)->first() ? $reimbursement->reimbursementMeals->where('day', 5)->where('meal', 1)->first()->price : '',
                $reimbursement->reimbursementMeals->where('day', 5)->where('meal', 2)->first() ? $reimbursement->reimbursementMeals->where('day', 5)->where('meal', 2)->first()->price : '',
                $reimbursement->reimbursementMeals->where('day', 5)->where('meal', 3)->first() ? $reimbursement->reimbursementMeals->where('day', 5)->where('meal', 3)->first()->price : ''
            ],
            [
                $reimbursement->reimbursementMeals->where('day', 6)->where('meal', 1)->first() ? $reimbursement->reimbursementMeals->where('day', 6)->where('meal', 1)->first()->price : '',
                $reimbursement->reimbursementMeals->where('day', 6)->where('meal', 2)->first() ? $reimbursement->reimbursementMeals->where('day', 6)->where('meal', 2)->first()->price : '',
                $reimbursement->reimbursementMeals->where('day', 6)->where('meal', 3)->first() ? $reimbursement->reimbursementMeals->where('day', 6)->where('meal', 3)->first()->price : ''
            ],
        ];

        return view('site.dashboard.staff.conferences.reimbursement', compact('conference', 'reimbursement', 'page', 'meals'));
    }

    public function reimbursementPatch(Request $request, Conference $conference)
    {
        $reimbursement = Reimbursement::where('conference_id', $conference->id)->where('user_id', auth()->user()->id)->first();

        $reimbursement->name = $request->name;
        $reimbursement->address = $request->address;
        $reimbursement->city = $request->city;
        $reimbursement->state = $request->state;
        $reimbursement->zip = $request->zip;
        $reimbursement->comments = $request->comments;
        $reimbursement->on_duty = $request->on_duty;
        if ($request->completed) {
            $reimbursement->status = 'Submitted';
        }


        $total_items = 0;
        if ($request->item_id) {
            foreach ($request->item_id as $key => $value) {

                $item_id = $request->item_id[$key];

                if (empty($item_id)) {

                    if ($request->item_name[$key] || $request->item_price[$key]) {
                        $item = new ReimbursementItem;
                        $item->name = $request->item_name[$key];
                        $item->price = $request->item_price[$key];
                        $item->comments = $request->item_comments[$key];
                        $reimbursement->reimbursementItems()->save($item);
                        $total_items += $item->price;
                    }
                } else {
                    $item = ReimbursementItem::find($item_id);
                    if ($request->item_name[$key] || $request->item_price[$key]) {
                        $item->name = $request->item_name[$key];
                        $item->price = $request->item_price[$key];
                        $item->comments = $request->item_comments[$key];
                        $item->update();
                        $total_items += $item->price;
                    } else {
                        $item->delete();
                    }
                }
            }
        }

        $total_meals = 0;
        if ($request->meals) {
            foreach ($request->meals as $day => $meal_array) {
                foreach ($meal_array as $meal => $price) {

                    if ($price) {
                        $reimbursementMeal = ReimbursementMeal::where('day', $day)->where('meal', $meal)->first();
                        if ($reimbursementMeal) {
                            $reimbursementMeal->price = $price;
                            $reimbursementMeal->update();
                            $total_meals += $reimbursementMeal->price;
                        } else {
                            $reimbursementMeal = new ReimbursementMeal;
                            $reimbursementMeal->day = $day;
                            $reimbursementMeal->meal = $meal;
                            $reimbursementMeal->price = $price;
                            $reimbursement->reimbursementMeals()->save($reimbursementMeal);
                            $total_meals += $reimbursementMeal->price;
                        }
                    } else {
                        $reimbursement->reimbursementMeals()->where('day', $day)->where('meal', $meal)->delete();
                    }
                }
            }
        }

        $reimbursement->total_items = $total_items;
        $reimbursement->total_meals = $total_meals;
        $reimbursement->total = $total_items + $total_meals;
        $reimbursement->update();

        return redirect()->back()->with('success', 'Reimbursement submitted');
    }


    public function checkin(Conference $conference)
    {
        return view('site.dashboard.staff.conferences.checkin', compact('conference'));
    }
}
