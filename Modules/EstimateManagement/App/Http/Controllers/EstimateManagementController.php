<?php

namespace Modules\EstimateManagement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\EstimateManagement\App\Models\Estimates;

class EstimateManagementController extends Controller
{
    public function index()
    {
        $estimates=Estimates::where('created_by','=',Auth()->user()->id)->get();
        return view('estimatemanagement::index')->with('estimates',$estimates);
    }


    public function create()
    {
        return view('estimatemanagement::create');
    }

       /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'estimate_no' => 'required|unique:estimates,estimate_no',
            'metrix' => 'required',
            'client_name' => 'required',
            'client_contact_person_name' => 'required',
            'headline' => 'nullable',
            'amount' => 'nullable',
            'currency' => 'required',
            'status' => 'required|in:1,0,2',
        ]);

        $estimate = new Estimates();
        $estimate->estimate_no = $request->estimate_no;
        $estimate->metrix = $request->metrix;
        $estimate->client_name = $request->client_name;
        $estimate->client_contact_person_name = $request->client_contact_person_name;
        $estimate->headline = $request->headline;
        $estimate->amount = $request->amount;
        $estimate->currency = $request->currency;
        $estimate->status = $request->status;
        $estimate->created_by = Auth()->user()->id;
        $estimate->updated_by = Auth()->user()->id;
        $estimate->save();
        return redirect('/estimate-management');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $estimate=Estimates::find($id);
        return view('estimatemanagement::show')->with('estimate',$estimate);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $estimate=Estimates::find($id);
        return view('estimatemanagement::edit')->with('estimate',$estimate);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'estimate_no' => 'required|unique:estimates,estimate_no,' . $id . ',id',
            'metrix' => 'required',
            'client_name' => 'required',
            'client_contact_person_name' => 'required',
            'headline' => 'nullable',
            'amount' => 'nullable',
            'currency' => 'required',
            'status' => 'required|in:1,0,2',
        ]);

        $estimate = Estimates::find($id);
        $estimate->estimate_no = $request->estimate_no;
        $estimate->metrix = $request->metrix;
        $estimate->client_name = $request->client_name;
        $estimate->client_contact_person_name = $request->client_contact_person_name;
        $estimate->headline = $request->headline;
        $estimate->amount = $request->amount;
        $estimate->currency = $request->currency;
        $estimate->status = $request->status;
        $estimate->updated_by = Auth()->user()->id;
        $estimate->save();

        return redirect('/estimate-management');
    }

  
}
