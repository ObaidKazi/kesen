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
            'estimate_document_id' => 'required|string|unique:job_register,estimate_document_id',
            'category' => 'required|integer',
            'type' => 'string',
            'date' => 'required|date',
            'description' => 'required|string',
            'protocol_no' => 'required|string',
            'status' => 'required|integer',
            'cancel_reason' => 'nullable|string',
            'bill_no' => 'nullable|string|max:255',
            'bill_date' => 'nullable|date',
            'informed_to' => 'nullable|string|max:255',
            'invoice_date' => 'nullable|date',
            'sent_date' => 'nullable|date',
            'site_specific' => 'nullable|string|max:255',
            'site_specific_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,csv|max:3048',
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
        $job_register->category = $request->category;
        $job_register->estimate_document_id = $request->estimate_document_id;
        $job_register->type = $request->type;
        $job_register->client_accountant_person_id = $request->client_accountant_person_id;
        $job_register->date = $request->date;
        $job_register->description = $request->description;
        $job_register->protocol_no = $request->protocol_no;
        $job_register->status = $request->status;
        $job_register->cancel_reason = $request->cancel_reason;
        $job_register->bill_no = $request->bill_no;
        $job_register->bill_date = $request->bill_date;
        $job_register->informed_to = $request->informed_to;
        $job_register->invoice_date = $request->invoice_date;
        $job_register->sent_date = $request->sent_date;
        $job_register->site_specific = $request->site_specific;
        if ($request['site_specific'] == 'yes' && $request->hasFile('site_specific_path')) {
            $path = $request->file('site_specific_path')->store('site_specific_files');
            $job_register->site_specific_path = $path;
        }

        $job_register->save();
        
        return redirect()->route('jobregistermanagement.index')->with('message', 'Job register created successfully.');
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
            'estimate_document_id' => 'required|string|unique:job_register,estimate_document_id,' . $id . ',id',
            'category' => 'required|integer',
            'type' => 'string',
            'date' => 'required|date',
            'description' => 'required|string',
            'protocol_no' => 'required|string',
            'status' => 'required|integer',
            'cancel_reason' => 'nullable|string',
            'bill_no' => 'nullable|string|max:255',
            'bill_date' => 'nullable|date',
            'informed_to' => 'nullable|string|max:255',
            'invoice_date' => 'nullable|date',
            'sent_date' => 'nullable|date',
            'site_specific' => 'nullable|string|max:255',
            'site_specific_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,csv|max:3048',
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
            'estimate_document_id' => $request->estimate_document_id,
            'category' => $request->category,
            'date' => $request->date,
            'description' => $request->description,
            'protocol_no' => $request->protocol_no,
            'status' => $request->status,
            'cancel_reason' => $request->cancel_reason,
            'bill_no' => $request->bill_no,
            'bill_date' => $request->bill_date,
            'informed_to' => $request->informed_to,
            'invoice_date' => $request->invoice_date,
            'sent_date' => $request->sent_date,
            'site_specific' => $request->site_specific,
        ]);

        if ($request['site_specific'] == 'yes' && $request->hasFile('site_specific_path')) {
            $path = $request->file('site_specific_path')->store('site_specific_files');
            $jobRegister->site_specific_path = $path;
        }

        return redirect()->route('jobregistermanagement.index')->with('message', 'Job register updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

}
