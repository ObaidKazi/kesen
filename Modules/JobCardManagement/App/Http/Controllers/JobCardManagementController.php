<?php

namespace Modules\JobCardManagement\App\Http\Controllers;

use App\Http\Controllers\Controller;

class JobCardManagementController extends Controller
{

    public function index(){
        
        return view('jobcardmanagement::index');
    }
}
