<?php

namespace Modules\JobRegisterManagement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Modules\ClientManagement\App\Models\Client;
use Modules\EstimateManagement\App\Models\Estimates;
use Modules\JobRegisterManagement\App\Models\JobRegister;
use Modules\LanguageManagement\App\Models\Language;

class JobRegisterManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $job_registers=JobRegister::all();
        return view('jobregistermanagement::index')->with('job_registers',$job_registers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jobregistermanagement::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|string',
            'client_contact_person_id' => 'required|string',
            'estimate_id' => 'required|string',
            'metrix' => 'required|string',
            'handled_by_id' => 'required|string',
            'client_accountant_person_id' => 'required|string',
            'other_details' => 'required|string',
            'type' => 'required|integer',
            'language' => 'required|string',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'protocol_no' => 'nullable|string',
            'status' => 'required|integer',
            'cancel_reason' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $job_register=new JobRegister();
        $job_register->client_id = $request->client_id;
        $job_register->client_contact_person_id = $request->client_contact_person_id;
        $job_register->estimate_id = $request->estimate_id;
        $job_register->metrix = $request->metrix;
        $job_register->handled_by_id = $request->handled_by_id;
        $job_register->created_by_id = auth()->user()->id;
        $job_register->other_details = $request->other_details;
        $job_register->type = $request->type;
        $job_register->client_accountant_person_id = $request->client_accountant_person_id;
        $job_register->language_id = $request->language;
        $job_register->date = $request->date;
        $job_register->description = $request->description;
        $job_register->protocol_no = $request->protocol_no;
        $job_register->status = $request->status;
        $job_register->cancel_reason = $request->cancel_reason;
        $job_register->save();
        
        return redirect()->route('jobregistermanagement.index')->with('success', 'Job register created successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $jobRegister = JobRegister::findOrFail($id);
        return view('jobregistermanagement::show', compact('jobRegister'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $jobRegister = JobRegister::findOrFail($id);
       
        return view('jobregistermanagement::edit', compact('jobRegister'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|string',
            'client_contact_person_id' => 'required|string',
            'estimate_id' => 'required|string',
            'metrix' => 'required|string',
            'handled_by_id' => 'required|string',
            'client_accountant_person_id' => 'required|string',
            'other_details' => 'required|string',
            'type' => 'required|integer',
            'language' => 'required|string',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'protocol_no' => 'nullable|string',
            'status' => 'required|integer',
            'cancel_reason' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $jobRegister = JobRegister::findOrFail($id);
        $jobRegister->update([
            'client_id' => $request->client_id,
            'client_contact_person_id' => $request->client_contact_person_id,
            'estimate_id' => $request->estimate_id,
            'metrix' => $request->metrix,
            'client_accountant_person_id'=> $request->client_accountant_person_id,
            'handled_by_id' => $request->handled_by_id,
            'other_details' => $request->other_details,
            'type' => $request->type,
            'language_id' => $request->language,
            'date' => $request->date,
            'description' => $request->description,
            'protocol_no' => $request->protocol_no,
            'status' => $request->status,
            'cancel_reason' => $request->cancel_reason,
        ]);

        return redirect()->route('jobregistermanagement.index')->with('success', 'Job register updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
