<?php

namespace Modules\WriterManagement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\LanguageManagement\App\Models\Language;
use Modules\WriterManagement\App\Models\Writer;
use Modules\WriterManagement\App\Models\WriterLanguageMap;

class WriterManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $writers=Writer::all();
        return view('writermanagement::index')->with('writers',$writers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('writermanagement::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'writer_name' => 'required',
            'email' => 'required|email|unique:writers',
            'phone' => 'required|numeric',
            'landline' => 'nullable|numeric',
            'address' => 'nullable',
            'code'=>'required' 
        ]);
        $writer=new Writer();
        $writer->writer_name=$request->writer_name;
        $writer->email=$request->email;
        $writer->phone_no=$request->phone;
        $writer->landline=$request->landline;
        $writer->address=$request->address;
        $writer->code=$request->code;
        $writer->created_by=auth()->user()->id;
        $writer->updated_by=auth()->user()->id;
        $writer->save();
        return redirect()->route('writermanagement.index')->with('success','Writer Added Successfully');

    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('writermanagement::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $writer=Writer::find($id);
        return view('writermanagement::edit')->with('writer',$writer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'writer_name' => 'required',
            'email' => 'required|email|unique:writers,email,'.$id,
            'phone' => 'required|numeric',
            'landline' => 'nullable|numeric',
            'address' => 'nullable',
            'code'=>'required' 
        ]);
        $writer=Writer::find($id);
        $writer->writer_name=$request->writer_name;
        $writer->email=$request->email;
        $writer->phone_no=$request->phone;
        $writer->landline=$request->landline;
        $writer->address=$request->address;
        $writer->code=$request->code;
        $writer->updated_by=auth()->user()->id;
        $writer->save();
        return redirect()->route('writermanagement.index')->with('success','Writer Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function viewLanguageMaps($writer_id){
        $language_map=WriterLanguageMap::where('writer_id',$writer_id)->get();
        return view('writermanagement::language-maps')->with('language_map',$language_map)->with('id',$writer_id);
    }

    public  function deleteLanguageMap($writer_id,$id){
        $language_map=WriterLanguageMap::find($id);
        $language_map->delete();
        return redirect(route('writermanagement.viewLanguageMaps',['writer_id'=>$writer_id]));
    }

    public function editLanguageMap($writer_id,$id){
        $languages=Language::all();
        $language_map=WriterLanguageMap::find($id);
        
        return view('writermanagement::edit-language')->with('language_map',$language_map)->with('id',$writer_id)->with('languages',$languages);
    }

    public function updateLanguageMap($writer_id,$id,Request $request){
        $request->validate([
            'language' => 'required|exists:languages,id',
            'per_unit_charges' => 'required|numeric',
            'checking_charges'=>'required|numeric',
            'bt_charges'=>'required|numeric',
            'bt_checking_charges'=>'required|numeric',
            'advertising_charges'=>'required|numeric',
        ]);
        $language_map=WriterLanguageMap::find($id);
        $language_map->language_id=$request->language;
        $language_map->per_unit_charges=$request->per_unit_charges;
        $language_map->checking_charges=$request->checking_charges;
        $language_map->bt_charges=$request->bt_charges;
        $language_map->bt_checking_charges=$request->bt_checking_charges;
        $language_map->advertising_charges=$request->advertising_charges;
        $language_map->save();
        Toastr::success('Language Map Updated Successfully', 'Success');
        return redirect(route('writermanagement.viewLanguageMaps',['writer_id'=>$writer_id]));
    }

    public function addLanguageMapView($writer_id){
        $languages=Language::all();
        return view('writermanagement::add-language')->with('id',$writer_id)->with('languages',$languages);
    }

    public function addLanguageMap($writer_id,Request $request){
        $request->validate([
            'language' => 'required|exists:languages,id',
            'per_unit_charges' => 'required|numeric',
            'checking_charges'=>'required|numeric',
            'bt_charges'=>'required|numeric',
            'bt_checking_charges'=>'required|numeric',
            'advertising_charges'=>'required|numeric',

        ]);
        $language_map=new WriterLanguageMap();
        $language_map->writer_id=$writer_id;
        $language_map->language_id=$request->language;
        $language_map->per_unit_charges=$request->per_unit_charges;
        $language_map->checking_charges=$request->checking_charges;
        $language_map->bt_charges=$request->bt_charges;
        $language_map->bt_checking_charges=$request->bt_checking_charges;
        $language_map->advertising_charges=$request->advertising_charges;
        $language_map->save();
        Toastr::success('Language Map Added Successfully', 'Success');
        return redirect(route('writermanagement.viewLanguageMaps',['writer_id'=>$writer_id]));
        
    }

    public function disableEnableWriter($id){
        $writer=Writer::find($id);
        if($writer->status==1){
            $writer->status=0;
        }else{
            $writer->status=1;
        }
        $writer->save();
        return redirect()->route('writermanagement.index');
    }
}
