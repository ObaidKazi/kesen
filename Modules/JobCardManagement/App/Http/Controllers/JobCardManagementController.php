<?php

namespace Modules\JobCardManagement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Modules\EstimateManagement\App\Models\Estimates;
use Modules\EstimateManagement\App\Models\EstimatesDetails;
use Modules\JobCardManagement\App\Models\JobCard;
use Modules\JobRegisterManagement\App\Models\JobRegister;

class JobCardManagementController extends Controller
{

    public function index(){ 
        $estimate_details=EstimatesDetails::whereHas('jobRegister')->get();
        return view('jobcardmanagement::manage',compact('estimate_details'));
        
    }

    public function create($job_id,$estimate_detail_id){
        
        $job_register = JobRegister::where('id',$job_id)->first();
       
        $estimate_detail=EstimatesDetails::where('id',$estimate_detail_id)->first();
        $job_card=JobCard::where('job_no',$job_register->sr_no)->where('estimate_detail_id',$estimate_detail->id)->get();
        if(count($job_card)>0){
            return view('jobcardmanagement::edit',compact('job_card','job_register','estimate_detail'));
        }
        
        return view('jobcardmanagement::create',compact('job_register','estimate_detail'));
    }

    public function viewPdf($job_id){
        $job_register = JobRegister::with(['estimateDetail', 'jobCard', 'client', 'handle_by', 'client_person'])
        ->where('id', $job_id)
        ->first();
    

       return view('jobcardmanagement::pdf')->with('job',$job_register);
    }

    public function store(Request $request)
    {
        $request->validate([
            't_writer.*' => 'required|string|max:255',
            't_emp_code.*' => 'required|string|max:255',
            't_pd.*' => 'required|string|max:255',
            't_cr.*' => 'required|string|max:255',
            't_cnc.*' => 'required|string|max:255',
            't_dv.*' => 'required|string|max:255',
            't_fqc.*' => 'required|string|max:255',
            't_sentdate.*' => 'required|string|max:255',
            'v_writer.*' => 'nullable|string|max:255',
            'v_emp_code.*' => 'nullable|string|max:255',
            'v_pd.*' => 'nullable|string|max:255',
            'v_cr.*' => 'nullable|string|max:255',
            'v_cnc.*' => 'nullable|string|max:255',
            'v_dv.*' => 'nullable|string|max:255',
            'v_fqc.*' => 'nullable|string|max:255',
            'v_sentdate.*' => 'nullable|string|max:255',
            'bt_writer.*' => 'nullable|string|max:255',
            'bt_emp_code.*' => 'nullable|string|max:255',
            'bt_pd.*' => 'nullable|string|max:255',
            'bt_cr.*' => 'nullable|string|max:255',
            'bt_cnc.*' => 'nullable|string|max:255',
            'bt_dv.*' => 'nullable|string|max:255',
            'bt_fqc.*' => 'nullable|string|max:255',
            'bt_sentdate.*' => 'nullable|string|max:255',
            'btv_writer.*' => 'nullable|string|max:255',
            'btv_emp_code.*' => 'nullable|string|max:255',
            'btv_pd.*' => 'nullable|string|max:255',
            'btv_cr.*' => 'nullable|string|max:255',
            'btv_cnc.*' => 'nullable|string|max:255',
            'btv_dv.*' => 'nullable|string|max:255',
            'btv_fqc.*' => 'nullable|string|max:255',
            'btv_sentdate.*' => 'nullable|string|max:255',
        ]);

        
        $carbon=Carbon::now()->getTimestampMs();
        
        foreach ($request['t_writer'] as $index => $t_writer) {

            $jobCard = new JobCard();

            $jobCard->t_writer_code = $t_writer;
            $jobCard->t_emp_code = $request['t_emp_code'][$index];
            $jobCard->t_pd = $request['t_pd'][$index];
            $jobCard->t_cr = $request['t_cr'][$index];
            $jobCard->t_cnc = $request['t_cnc'][$index];
            $jobCard->t_dv = $request['t_dv'][$index];
            $jobCard->t_fqc = $request['t_fqc'][$index];
            $jobCard->t_sentdate = $request['t_sentdate'][$index];
            $jobCard->v_writer_code = $request['v_writer'][$index] ?? null;
            $jobCard->v_emp_code = $request['v_emp_code'][$index] ?? null;
            $jobCard->v_pd = $request['v_pd'][$index] ?? null;
            $jobCard->v_cr = $request['v_cr'][$index] ?? null;
            $jobCard->v_cnc = $request['v_cnc'][$index] ?? null;
            $jobCard->v_dv = $request['v_dv'][$index] ?? null;
            $jobCard->v_fqc = $request['v_fqc'][$index] ?? null;
            $jobCard->v_sentdate = $request['v_sentdate'][$index] ?? null;
            $jobCard->bt_writer_code = $request['bt_writer'][$index] ?? null;
            $jobCard->bt_emp_code = $request['bt_emp_code'][$index] ?? null;
            $jobCard->bt_pd = $request['bt_pd'][$index] ?? null;
            $jobCard->bt_cr = $request['bt_cr'][$index] ?? null;
            $jobCard->bt_cnc = $request['bt_cnc'][$index] ?? null;
            $jobCard->bt_dv = $request['bt_dv'][$index] ?? null;
            $jobCard->bt_fqc = $request['bt_fqc'][$index] ?? null;
            $jobCard->bt_sentdate = $request['bt_sentdate'][$index] ?? null;
            $jobCard->btv_writer_code = $request['btv_writer'][$index] ?? null;
            $jobCard->btv_emp_code = $request['btv_emp_code'][$index] ?? null;
            $jobCard->btv_pd = $request['btv_pd'][$index] ?? null;
            $jobCard->btv_cr = $request['btv_cr'][$index] ?? null;
            $jobCard->btv_cnc = $request['btv_cnc'][$index] ?? null;
            $jobCard->btv_dv = $request['btv_dv'][$index] ?? null;
            $jobCard->btv_fqc = $request['btv_fqc'][$index] ?? null;
            $jobCard->btv_sentdate = $request['btv_sentdate'][$index] ?? null;
            $jobCard->job_no = $request['job_no'][0];
            $jobCard->estimate_detail_id = $request['estimate_detail_id'][0];
            $jobCard->sync_no = $carbon;
            $jobCard->save();

        }

        return redirect(route('jobcardmanagement.index'))->with('message', 'Job Card created successfully.');;
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
            't_writer.*' => 'required|string|max:255',
            't_emp_code.*' => 'required|string|max:255',
            't_pd.*' => 'required|string|max:255',
            't_cr.*' => 'required|string|max:255',
            't_cnc.*' => 'required|string|max:255',
            't_dv.*' => 'required|string|max:255',
            't_fqc.*' => 'required|string|max:255',
            't_sentdate.*' => 'required|string|max:255',
            'v_writer.*' => 'nullable|string|max:255',
            'v_emp_code.*' => 'nullable|string|max:255',
            'v_pd.*' => 'nullable|string|max:255',
            'v_cr.*' => 'nullable|string|max:255',
            'v_cnc.*' => 'nullable|string|max:255',
            'v_dv.*' => 'nullable|string|max:255',
            'v_fqc.*' => 'nullable|string|max:255',
            'v_sentdate.*' => 'nullable|string|max:255',
            'bt_writer.*' => 'nullable|string|max:255',
            'bt_emp_code.*' => 'nullable|string|max:255',
            'bt_pd.*' => 'nullable|string|max:255',
            'bt_cr.*' => 'nullable|string|max:255',
            'bt_cnc.*' => 'nullable|string|max:255',
            'bt_dv.*' => 'nullable|string|max:255',
            'bt_fqc.*' => 'nullable|string|max:255',
            'bt_sentdate.*' => 'nullable|string|max:255',
            'btv_writer.*' => 'nullable|string|max:255',
            'btv_emp_code.*' => 'nullable|string|max:255',
            'btv_pd.*' => 'nullable|string|max:255',
            'btv_cr.*' => 'nullable|string|max:255',
            'btv_cnc.*' => 'nullable|string|max:255',
            'btv_dv.*' => 'nullable|string|max:255',
            'btv_fqc.*' => 'nullable|string|max:255',
            'btv_sentdate.*' => 'nullable|string|max:255',
        ]);

        $carbon=Carbon::now()->getTimestampMs();
        
        foreach ($request['t_writer'] as $index => $t_writer) {
            JobCard::updateOrCreate([
                'id' => $request['id'][$index],
            ],[
            't_writer_code' => $t_writer,
            't_emp_code' => $request['t_emp_code'][$index],
            't_pd' => $request['t_pd'][$index],
            't_cr' => $request['t_cr'][$index],
            't_cnc' => $request['t_cnc'][$index],
            't_dv' => $request['t_dv'][$index],
            't_fqc' => $request['t_fqc'][$index],
            't_sentdate' => $request['t_sentdate'][$index],
            'v_writer_code' => $request['v_writer'][$index] ?? null,
            'v_emp_code' => $request['v_emp_code'][$index] ?? null,
            'v_pd' => $request['v_pd'][$index] ?? null,
            'v_cr' => $request['v_cr'][$index] ?? null,
            'v_cnc' => $request['v_cnc'][$index] ?? null,
            'v_dv' => $request['v_dv'][$index] ?? null,
            'v_fqc' => $request['v_fqc'][$index] ?? null,
            'v_sentdate' => $request['v_sentdate'][$index] ?? null,
            'bt_writer_code' => $request['bt_writer'][$index] ?? null,
            'bt_emp_code' => $request['bt_emp_code'][$index] ?? null,
            'bt_pd' => $request['bt_pd'][$index] ?? null,
            'bt_cr' => $request['bt_cr'][$index] ?? null,
            'bt_cnc' => $request['bt_cnc'][$index] ?? null,
            'bt_dv' => $request['bt_dv'][$index] ?? null,
            'bt_fqc' => $request['bt_fqc'][$index] ?? null,
            'bt_sentdate' => $request['bt_sentdate'][$index] ?? null,
            'btv_writer_code' => $request['btv_writer'][$index] ?? null,
            'btv_emp_code' => $request['btv_emp_code'][$index] ?? null,
            'btv_pd' => $request['btv_pd'][$index] ?? null,
            'btv_cr' => $request['btv_cr'][$index] ?? null,
            'btv_cnc' => $request['btv_cnc'][$index] ?? null,
            'btv_dv' => $request['btv_dv'][$index] ?? null,
            'btv_fqc' => $request['btv_fqc'][$index] ?? null,
            'btv_sentdate' => $request['btv_sentdate'][$index] ?? null,
            'job_no' => $request['job_no'][0],
            'estimate_detail_id' => $request['estimate_detail_id'][0],
            'sync_no' => $carbon,

            ]);
        }


        return redirect(route('jobcardmanagement.index'))->with('message', 'Job Card updated successfully.');;
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

    public function manage($job_id){
        $job_register = JobRegister::where('id',$job_id)->first();
        if($job_register!=null){
            $estimate_details=EstimatesDetails::where('estimate_id',$job_register->estimate_id)->where('document_name',$job_register->estimate_document_id)->get();
            
            return view('jobcardmanagement::manage',compact('job_register','estimate_details'));
        }else{
            return abort(403, 'Job Register not found');
        }
        
    }

    public function manageDelete($job_card_id){
        $job_card = JobCard::find($job_card_id);
        if($job_card!=null){
            $job_card->delete();
            return response()->json(['success' => 'Job Card deleted successfully']);
        }else{
            return abort(403, 'Job Card not found');
        }
    }
}
