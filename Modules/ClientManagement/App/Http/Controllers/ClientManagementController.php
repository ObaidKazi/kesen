<?php

namespace Modules\ClientManagement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\ClientManagement\App\Models\Client;
use Modules\ClientManagement\App\Models\ContactPerson;

class ClientManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client=Client::all();
        return view('clientmanagement::index')->with('client',$client->values());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientmanagement::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:clients,email,except,id',
            'phone_no'=>'required|numeric|unique:clients,phone_no,except,id',
            'landline'=>'nullable|numeric|unique:clients,landline,except,id',
            'type'=>'required|in:1,2',
            'protocol_data'=>'required_if:type,2',
            'address'=>'nullable',
        ]);
        $client=new Client();
        $client->name=$request->name;
        $client->email=$request->email;
        $client->phone_no=$request->phone_no;
        $client->landline=$request->landline;
        $client->type=$request->type;
        $client->protocol_data=$request->protocol_data;
        $client->address=$request->address;
        $client->save();
        return redirect('/client-management');
    }
   
    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('clientmanagement::show');
    }

    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $client=Client::find($id);
        return view('clientmanagement::edit')->with('client',$client);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:clients,email,except,id',
            'phone_no'=>'required|numeric|unique:clients,phone_no,except,id',
            'landline'=>'nullable|numeric|unique:clients,landline,except,id',
            'type'=>'required|in:1,2',
            'protocol_data'=>'required_if:type,2',
            'address'=>'nullable',
        ]);
        $client=Client::find($id);
        $client->name=$request->name;
        $client->email=$request->email;
        $client->phone_no=$request->phone_no;
        $client->landline=$request->landline;
        $client->type=$request->type;
        $client->protocol_data=$request->protocol_data;
        $client->address=$request->address;
        $client->save();
        return redirect('/client-management');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function disableEnableClient($id){
        $client=Client::find($id);
        if($client->status==1){
            $client->status=0;
        }else{
            $client->status=1;
        }
        $client->save();
        return redirect('/client-management');
    }

    public function viewContacts($id){
        $contact_persons=ContactPerson::where('client_id',$id)->get();
        return view('clientmanagement::list_contacts')->with('id',$id)->with('contact_persons',$contact_persons);
    }

    public function addContactForm($id){
        return view('clientmanagement::add_contact')->with('id',$id);
    }

    public function storeContact(Request $request,$id){
        $request->validate([
            'name'=>'required',
            'email'=>'nullable|email|unique:contact_persons,email',
            'phone_no'=>'required|numeric|unique:contact_persons,phone_no',
            'landline'=>'nullable|numeric|unique:contact_persons,landline',
            'designation'=>'nullable',
        ]);
        $contact_persons=new ContactPerson();
        $contact_persons->name=$request->name;
        $contact_persons->client_id=$id;
        $contact_persons->email=$request->email;
        $contact_persons->phone_no=$request->phone_no;
        $contact_persons->landline=$request->landline;
        $contact_persons->designation=$request->designation;
        $contact_persons->save();
        return redirect(route('clientmanagement.viewContacts', $id));
    }


    
    public function editContactForm($id,$contact_id){
        $contact_person=ContactPerson::find($contact_id);
        return view('clientmanagement::edit_contact')->with('id',$id)->with('contact_person',$contact_person);
    }

    public function editContact(Request $request,$id,$contact_id){
        $request->validate([
            'name'=>'required',
            'email'=>'nullable|email|unique:contact_persons,email,' . $contact_id . ',id',
            'phone_no'=>'required|numeric|unique:contact_persons,phone_no,' . $contact_id . ',id',
            'landline'=>'nullable|numeric|unique:contact_persons,landline,' . $contact_id . ',id',
            'designation'=>'nullable',
        ]);
        $contact_person=ContactPerson::find($contact_id);
        $contact_person->name=$request->name;
        $contact_person->email=$request->email;
        $contact_person->phone_no=$request->phone_no;
        $contact_person->landline=$request->landline;
        $contact_person->designation=$request->designation;
        $contact_person->save();

        return redirect(route('clientmanagement.viewContacts', $id));
    }

    public function disableEnableContact($id,$contact_id){
        $contact_person=ContactPerson::find($contact_id);
        if($contact_person->status==1){
            $contact_person->status=0;
        }else{
            $contact_person->status=1;
        }
        $contact_person->save();
        return redirect(route('clientmanagement.viewContacts', $id));
    }
    public function deleteContact($id,$contact_id){
        $contact_person=ContactPerson::find($contact_id);
        $contact_person->delete();
        return redirect(route('clientmanagement.viewContacts', $id));
    }
}
