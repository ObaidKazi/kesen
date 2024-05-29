<?php

namespace Modules\EstimateManagement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\ClientManagement\App\Models\ContactPerson;
use Modules\EstimateManagement\App\Models\Estimates;
use Modules\EstimateManagement\App\Models\EstimatesDetails;
use Modules\JobRegisterManagement\App\Models\JobRegister;

class EstimateManagementController extends Controller
{
    public function index()
    {
        $estimates = Estimates::where('created_by', '=', Auth()->user()->id)->get();
        return view('estimatemanagement::index')->with('estimates', $estimates);
    }

    public function viewPdf($id)
    {
        $estimate = Estimates::where('id', $id)->first();
        $pdf = FacadePdf::loadView('estimatemanagement::pdf.estimate', ['estimate' => $estimate]);
        return $pdf->download('ESTIMATE-' . strtoupper(str_replace(' ', '-', $estimate->client->name)) . '.pdf');
    }

    public function getContactPerson($id)
    {

        if ($id == null && $id == '') {
            $html = '<option value="">Select Contact Person</option>';
        } else {

            $html = '<option value="">Select Contact Person</option>';
            $contact_persons = ContactPerson::where('client_id', $id)->get();

            foreach ($contact_persons as $contact) {
                $html .= '<option value="' . $contact->id . '">' . $contact->name . '</option>';
            }
        }

        return response()->json(['html' => $html]);
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
            'client_id' => 'required',
            'client_contact_person_id' => 'required',
            'headline' => 'nullable',
            'amount' => 'required',
            'currency' => 'required',
            'discount' => 'required',
            'status' => 'required|in:1,0,2',
            'document_name.*' => 'required|string|max:255',
            'type.*' => 'required|string|max:255',
            'unit.*' => 'required|numeric|max:255',
            'rate.*' => 'required|numeric',
            'verification.*' => 'required|string|max:255',
            'back_translation.*' => 'required|string|max:255',
            'layout_charges.*' => 'required|string|max:255',
            'layout_charges_second.*' => 'required|string|max:255',
            'lang.*' => 'required|string|max:255',
        ]);

        $estimate = new Estimates();
        $estimate->estimate_no = $request->estimate_no;
        $estimate->metrix = $request->metrix;
        $estimate->client_id = $request->client_id;
        $estimate->client_contact_person_id = $request->client_contact_person_id;
        $estimate->headline = $request->headline;
        $estimate->amount = $request->amount;
        $estimate->currency = $request->currency;
        $estimate->status = $request->status;
        $estimate->discount = $request->discount ?? 0;
        $estimate->created_by = Auth()->user()->id;
        $estimate->updated_by = Auth()->user()->id;
        $estimate->save();
        if ($request['document_name'] != null) {
            foreach ($request['document_name'] as $index => $document_name) {
                EstimatesDetails::create([
                    'estimate_id' => $estimate->id,
                    'document_name' => $document_name,
                    'type' => $request['type'][$index],
                    'unit' => $request['unit'][$index],
                    'rate' => $request['rate'][$index],
                    'verification' => $request['verification'][$index],
                    'verification_2' => $request['verification_2'][$index],
                    'back_translation' => $request['back_translation'][$index],
                    'layout_charges' => $request['layout_charges'][$index],
                    'layout_charges_2' => $request['layout_charges_second'][$index],
                    'lang' => $request['lang'][$index]
                ]);
            }
        }
        Session::flash('message', 'Estimate created successfully');
        return redirect('/estimate-management');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $estimate = Estimates::where('id', $id)->with('client', 'client_person')->first();
        $estimate_details = EstimatesDetails::where('estimate_id', $id)->get();
        return view('estimatemanagement::show', compact('estimate', 'estimate_details'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $estimate = Estimates::find($id);
        $contact_persons = ContactPerson::where('client_id', $estimate->client_id)->get();
        $estimate_details = EstimatesDetails::where('estimate_id', $id)->get();
        return view('estimatemanagement::edit', compact('estimate', 'contact_persons', 'estimate_details'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'estimate_no' => 'required|unique:estimates,estimate_no,' . $id . ',id',
            'metrix' => 'required',
            'client_id' => 'required',
            'client_contact_person_id' => 'required',
            'headline' => 'nullable',
            'amount' => 'required',
            'discount' => 'required',
            'currency' => 'required',
            'status' => 'required|in:1,0,2',
            'document_name.*' => 'required|string|max:255',
            'type.*' => 'required|string|max:255',
            'unit.*' => 'required|numeric|max:255',
            'rate.*' => 'required|numeric',
            'verification.*' => 'required|string|max:255',
            'back_translation.*' => 'required|string|max:255',
            'layout_charges.*' => 'required|string|max:255',
            'layout_charges_second.*' => 'required|string|max:255',
            'lang.*' => 'required|string|max:255',
        ]);

        $estimate = Estimates::find($id);
        $estimate->estimate_no = $request->estimate_no;
        $estimate->metrix = $request->metrix;
        $estimate->client_id = $request->client_id;
        $estimate->client_contact_person_id = $request->client_contact_person_id;
        $estimate->headline = $request->headline;
        $estimate->amount = $request->amount;
        $estimate->discount = $request->discount ?? 0;
        $estimate->currency = $request->currency;
        $estimate->status = $request->status;
        $estimate->updated_by = Auth()->user()->id;
        $estimate->save();
        
        foreach ($request['document_name'] as $index => $document_name) {
            EstimatesDetails::updateOrCreate([
                'id' => isset($request['id'][$index]) ? $request['id'][$index] : null
            ], [
                'estimate_id' => $estimate->id,
                'document_name' => $document_name,
                'type' => $request['type'][$index],
                'unit' => $request['unit'][$index],
                'rate' => $request['rate'][$index],
                'verification' => $request['verification'][$index],
                'verification_2' => $request['verification_2'][$index],
                'back_translation' => $request['back_translation'][$index],
                'layout_charges' => $request['layout_charges'][$index],
                'layout_charges_2' => $request['layout_charges_second'][$index],
                'lang' => $request['lang'][$index]
            ]);
        
    }
        Session::flash('message', 'Estimate updated successfully');
        return redirect('/estimate-management');
    }

    public function getEstimateData($id)
    {
        $estimate = Estimates::where('id', $id)->first();
        if ($estimate != null) {
            return $estimate;
        } else {
            return false;
        }
    }
    public function deleteDetail($id)
    {
        $detail = EstimatesDetails::findOrFail($id);
        if ($detail == null) {
            return response()->json(['success' => 'Detail not found'], 403);
        }
        $detail->delete();
        return response()->json(['success' => 'Detail deleted successfully']);
    }


    public function getEstimateDetails($id)
    {
        $html = '<option value="">Select Estimate Document</option>';
        if ($id == null || $id == '') {
            return response()->json(['html' => $html]);
        }
        $job_register = JobRegister::where('estimate_id', $id)->pluck('estimate_document_id');
        $estimate_details = EstimatesDetails::where('estimate_id', $id)->whereNotIn('document_name', $job_register)->distinct()->pluck('document_name');
        if (count($estimate_details) > 0) {
            $html = '<option value="">Select Estimate Document</option>';
            foreach ($estimate_details as $document_name) {
                $html .= '<option value=' . $document_name . '>' . $document_name . '</option>';
            }
        }
        return response()->json(['html' => $html]);
    }
}
