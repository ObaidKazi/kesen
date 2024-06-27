<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\JobCardManagement\App\Models\JobCard;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Modules\JobRegisterManagement\App\Models\JobRegister;
use Modules\WriterManagement\App\Models\WriterPayment;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('page');
    }

    public function showBillReportForm()
    {
        return view('reports.bills-report');
    }
    public function showPaymentlReportForm(){
        return view('reports.payment-report');
    }
    public function showWriterReportForm(){
        return view('reports.writer-report');
    }

    public function generateBillReport()
    {
        $min = Carbon::parse(request()->get('from_date'))->startOfDay();
        $max = Carbon::parse(request()->get('to_date'))->endOfDay();
        $bill_data=JobRegister::where('created_at', '>=',Carbon::parse(request()->get("from_date"))->startOfDay())->where('created_at', '<=',Carbon::parse(request()->get("to_date"))->endOfDay())->get();
        $pdf = FacadePdf::loadView('reports.pdf.pdf-bill',compact('bill_data','max','min'));
        return $pdf->stream();
        
    }
    public function generatePaymentReport(Request $request){
        $min = Carbon::parse(request()->get('from_date'))->startOfDay();
        $max = Carbon::parse(request()->get('to_date'))->endOfDay();
        $job_card = JobCard::where(function ($query) use ($request) {
            $query->where('t_writer_code', $request->writer)
                  ->orWhere('bt_writer_code', $request->writer);
        })
        ->where('created_at', '>=', Carbon::parse($request->get('from_date'))->startOfDay())
        ->where('created_at', '<=', Carbon::parse($request->get('to_date'))->endOfDay())
        ->get();
        
        $pdf = FacadePdf::loadView('reports.pdf.pdf-payment',compact('job_card','max','min'));
        return $pdf->stream();
        
    }
    public function generateWriterReport(){
        $min = Carbon::parse(request()->get('from_date'))->startOfDay();
        $max = Carbon::parse(request()->get('to_date'))->endOfDay();

    $writer_report = WriterPayment::whereBetween('created_at', [$min, $max])
        ->selectRaw('writer_id, SUM(performance_charge) as total_performance_charge')
        ->groupBy('writer_id')
        ->get();
    $pdf = FacadePdf::loadView('reports.pdf.pdf-writer',compact('writer_report','min','max'));
    return $pdf->stream();
        
    }
}
