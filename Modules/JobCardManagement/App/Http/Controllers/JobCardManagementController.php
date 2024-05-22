<?php

namespace Modules\JobCardManagement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Modules\EstimateManagement\App\Models\Estimates;
use Modules\JobCardManagement\App\Models\JobCard;


class JobCardManagementController extends Controller
{

    public function index(){ 
        $job_cards=JobCard::all();
        return view('jobcardmanagement::index')->with('job_cards',$job_cards);
    }

    public function create(){ 
        return view('jobcardmanagement::create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'job_card_no' => 'required|string|max:255|unique:job_cards,job_card_no',
            'date' => 'required|date',
            'protocol_no' => 'nullable|string|max:255',
            'client_id' => 'nullable|string',
            'estimate_id' => 'nullable|string',
            'description' => 'nullable|string',
            'handled_by' => 'nullable|string',
            'bill_no' => 'nullable|string|max:255',
            'bill_date' => 'nullable|date',
            'informed_to' => 'nullable|string|max:255',
            'invoice_date' => 'nullable|date',
            'pd' => 'nullable|string|max:255',
            'cr' => 'nullable|string|max:255',
            'cn' => 'nullable|string|max:255',
            'dv' => 'nullable|string|max:255',
            'qc' => 'nullable|string|max:255',
            'sent_date' => 'nullable|date',
            'site_specific' => 'nullable|string|max:255',
            'site_specific_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,csv|max:3048',
        ]);

        

        $jobCard = new JobCard();
        $jobCard->fill($request->except('site_specific_path'));

        if ($request['site_specific'] == 'yes' && $request->hasFile('site_specific_path')) {
            $path = $request->file('site_specific_path')->store('site_specific_files');
            $jobCard->site_specific_path = $path;
        }

        $jobCard->save();

        return redirect(route('jobcardmanagement.index'));
    }

    public function show($id)
    {
        $jobCard = JobCard::find($id);

        if (!$jobCard) {
            return abort(403, 'Job Card not found');
        }

        return view('jobcardmanagement::show')->with('jobCard', $jobCard);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'job_card_no' => 'required|string|max:255|unique:job_cards,job_card_no,' . $id . ',id',
            'date' => 'required|date',
            'protocol_no' => 'nullable|string|max:255',
            'client_id' => 'nullable|string',
            'estimate_id' => 'nullable|string',
            'description' => 'nullable|string',
            'handled_by' => 'nullable|string',
            'bill_no' => 'nullable|string|max:255',
            'bill_date' => 'nullable|date',
            'informed_to' => 'nullable|string|max:255',
            'invoice_date' => 'nullable|date',
            'pd' => 'nullable|string|max:255',
            'cr' => 'nullable|string|max:255',
            'cn' => 'nullable|string|max:255',
            'dv' => 'nullable|string|max:255',
            'qc' => 'nullable|string|max:255',
            'sent_date' => 'nullable|date',
            'site_specific' => 'nullable|string|max:255',
            'site_specific_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,csv|max:3048',
        ]);

        $jobCard = JobCard::find($id);

        if (!$jobCard) {
            return abort(403, 'Job Card not found');
        }

        $jobCard->fill($request->except('site_specific_path'));

        if ($request['site_specific'] == 'yes' && $request->hasFile('site_specific_path')) {
            if ($jobCard->site_specific_path) {
                Storage::delete($jobCard->site_specific_path);
            }
            $path = $request->file('site_specific_path')->store('site_specific_files');
            $jobCard->site_specific_path = $path;
        }

        $jobCard->save();

        return redirect(route('jobcardmanagement.index'));
    }

    public function edit($id){

        $jobCard = JobCard::find($id);
        if(!$jobCard){
            return abort(403, 'Job Card not found');
        }
        return view('jobcardmanagement::edit')->with('jobCard', $jobCard);
    }

    public function getEstimateNo($client_id){
        if ($client_id==null&&$client_id=='') {
            $html = '<option value="">Select Estimate Number</option>';
        } else {
            
            $html = '<option value="">Select Estimate Number</option>';
            $estimates=Estimates::where('client_id',$client_id)->get();
            
            foreach ($estimates as $estimate) {
                $html .= '<option value='.$estimate->id.'>'.$estimate->estimate_no.'</option>';
            }
        }
    
        return response()->json(['html' => $html]);
    }

}
