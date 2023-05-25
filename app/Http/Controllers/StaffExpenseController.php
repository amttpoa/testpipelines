<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseItem;
use App\Models\ExpenseUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StaffExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('site.dashboard.staff.expenses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('site.dashboard.staff.expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $expense = new Expense;
        $expense->user_id = auth()->user()->id;
        $expense->title = $request->title;
        $expense->date = $request->date;
        $expense->location = $request->location;
        $expense->payer = $request->payer;
        $expense->card = $request->card;
        // $expense->total = $request->total;
        $expense->comments = $request->comments;
        $expense->save();


        $total = 0;
        if ($request->item_name) {
            foreach ($request->item_name as $key => $value) {
                if (!empty($value)) {
                    $item = new ExpenseItem;
                    $item->name = $request->item_name[$key];
                    $item->price = $request->item_price[$key];
                    $item->comments = $request->item_comments[$key];
                    $expense->expenseItems()->save($item);
                    $total += $item->price;
                }
            }
        }

        $expense->total = $total;
        $expense->update();


        if ($request->file('files')) {
            foreach ($request->file('files') as $file) {
                $originalName = $file->getClientOriginalName();
                $fileName = "EXP-" . $expense->id . "-" . time() . "-" . $originalName;

                Storage::disk('s3')->putFileAs('expenses', $file, $fileName);

                $upload = new ExpenseUpload;
                $upload->user_id = auth()->user()->id;
                $upload->file_name = $fileName;
                $upload->file_original = $originalName;
                $expense->expenseUploads()->save($upload);
            }
        }

        return redirect()->route('dashboard.staff.expenses.index')->with('success', 'Expense Submitted');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
