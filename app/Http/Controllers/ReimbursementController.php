<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Reimbursement;
use Illuminate\Http\Request;

class ReimbursementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Conference $conference)
    {
        return view('reimbursements.index', compact('conference'));
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
     * @param  \App\Models\Reimbursement  $reimbursement
     * @return \Illuminate\Http\Response
     */
    public function show(Conference $conference, Reimbursement $reimbursement)
    {
        $statuses = [
            'Open' => 'Open',
            'Submitted' => 'Submitted',
            'Approved' => 'Approved',
            'Paid' => 'Paid',
        ];

        return view('reimbursements.show', compact('conference', 'reimbursement', 'statuses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reimbursement  $reimbursement
     * @return \Illuminate\Http\Response
     */
    public function edit(Reimbursement $reimbursement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reimbursement  $reimbursement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conference $conference, Reimbursement $reimbursement)
    {
        $reimbursement->status = $request->status;
        $reimbursement->paid = $request->paid;
        $reimbursement->update();

        return redirect()->back()->with('success', 'Reimbursement updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reimbursement  $reimbursement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reimbursement $reimbursement)
    {
        //
    }
}
