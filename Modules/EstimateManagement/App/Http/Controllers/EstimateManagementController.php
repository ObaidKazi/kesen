<?php

namespace Modules\EstimateManagement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\ClientManagement\App\Models\ContactPerson;
use Modules\EstimateManagement\App\Models\Estimates;

class EstimateManagementController extends Controller
{
    public function index()
    {
        $estimates=Estimates::where('created_by','=',Auth()->user()->id)->get();
        return view('estimatemanagement::index')->with('estimates',$estimates);
    }

    public function viewPdf($id)
    {
        $estimate=Estimates::where('id',$id)->first();
        $pdf = FacadePdf::loadView('estimatemanagement::pdf.estimate',['estimate'=>$estimate]);
        return $pdf->download('estimate-'.str_replace(' ', '-', $estimate->client->name).' .pdf');
    }

    public function getContactPerson($id){
        
        if ($id==null&&$id=='') {
            $html = '<option value="">Select Contact Person</option>';
        } else {
            
            $html = '<option value="">Select Contact Person</option>';
            $contact_persons=ContactPerson::where('client_id',$id)->get();
            
            foreach ($contact_persons as $contact) {
                $html .= '<option value="'.$contact->id.'">'.$contact->name.'</option>';
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
            'amount' => 'nullable',
            'currency' => 'required',
            'status' => 'required|in:1,0,2',
            "unit"=>'required',
            "rate"=>'required',
            "verification"=>'required',
            "bank_translation"=>'required',
            "layout_charges"=>'required',
            "layout_charges_2"=>'required',
            "lang"=>'required',

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
        $estimate->unit = $request->unit;
        $estimate->rate = $request->rate;
        $estimate->verification = $request->verification;
        $estimate->bank_translation = $request->bank_translation;
        $estimate->layout_charges = $request->layout_charges;
        $estimate->layout_charges_2 = $request->layout_charges_2;
        $estimate->lang = $request->lang;
        $estimate->created_by = Auth()->user()->id;
        $estimate->updated_by = Auth()->user()->id;
        $estimate->save();
        return redirect('/estimate-management')->with('message', 'Estimate created successfully.');;
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $estimate=Estimates::where('id',$id)->with('client','client_person')->first();
        return view('estimatemanagement::show')->with('estimate',$estimate);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $estimate=Estimates::find($id);
        $contact_persons=ContactPerson::where('client_id',$estimate->client_id)->get();
        return view('estimatemanagement::edit',compact('estimate','contact_persons'));
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
            'amount' => 'nullable',
            'currency' => 'required',
            'status' => 'required|in:1,0,2',
            "unit"=>'required',
            "rate"=>'required',
            "verification"=>'required',
            "bank_translation"=>'required',
            "layout_charges_2"=>'required',
            "layout_charges"=>'required',
            "lang"=>'required',
        ]);

        $estimate = Estimates::find($id);
        $estimate->estimate_no = $request->estimate_no;
        $estimate->metrix = $request->metrix;
        $estimate->client_id = $request->client_id;
        $estimate->client_contact_person_id = $request->client_contact_person_id;
        $estimate->headline = $request->headline;
        $estimate->amount = $request->amount;
        $estimate->currency = $request->currency;
        $estimate->status = $request->status;
        $estimate->unit = $request->unit;
        $estimate->rate = $request->rate;
        $estimate->verification = $request->verification;
        $estimate->bank_translation = $request->bank_translation;
        $estimate->layout_charges = $request->layout_charges;
        $estimate->layout_charges_2 = $request->layout_charges_2;
        $estimate->lang = $request->lang;
        $estimate->updated_by = Auth()->user()->id;
        $estimate->save();

        return redirect('/estimate-management')->with('message', 'Estimate updated successfully.');;
    }

  
}
