<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Modules\JobRegisterManagement\App\Models\JobRegister;
use Carbon\Carbon;

class ShareJobRegisters
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $current = Carbon::now('Asia/Kolkata');
        
        // Define the time ranges in IST
        if(Auth::user()->hasRole('Accounts')){
            $start_time = Carbon::now('Asia/Kolkata')->subHours(1);
            $end_time = Carbon::now('Asia/Kolkata');
    
            // Check if the current time is within the specified ranges
            if ($current->between($start_time, $end_time)) {
    
                
                $job_registers_near_deadline = JobRegister::whereBetween('updated_at', [$start_time, $end_time])
                    ->get();
    
    
                View::share('job_registers_near_deadline', $job_registers_near_deadline);
    
                return $next($request);
            } else {
                View::share('job_registers_near_deadline', []);
                return $next($request);
            }
        }else{
            $startMorning = Carbon::parse('10:00', 'Asia/Kolkata');
            $endMorning = Carbon::parse('11:00', 'Asia/Kolkata');
            $startAfternoon = Carbon::parse('16:00', 'Asia/Kolkata');
            $endAfternoon = Carbon::parse('17:00', 'Asia/Kolkata');
    
            // Check if the current time is within the specified ranges
            if ($current->between($startMorning, $endMorning) || $current->between($startAfternoon, $endAfternoon)) {
    
                $deadline_3_days_date_start = Carbon::now()->addDays(3)->startOfDay();
                $deadline_3_days_date_end = Carbon::now()->addDays(3)->endOfDay();
                $deadline_2_days_date_start = Carbon::now()->addDays(2)->startOfDay();
                $deadline_2_days_date_end = Carbon::now()->addDays(2)->endOfDay();
                $deadline_1_days_date_start = Carbon::now()->addDays(1)->startOfDay();
                $deadline_1_days_date_end = Carbon::now()->addDays(1)->endOfDay();
                $deadline_date_start = Carbon::now()->startOfDay();
                $deadline_date_end = Carbon::now()->endOfDay();
    
                $job_registers_near_deadline = JobRegister::whereBetween('date', [$deadline_3_days_date_start, $deadline_3_days_date_end])
                    ->orWhereBetween('date', [$deadline_2_days_date_start, $deadline_2_days_date_end])
                    ->orWhereBetween('date', [$deadline_1_days_date_start, $deadline_1_days_date_end])
                    ->orWhereBetween('date', [$deadline_date_start, $deadline_date_end])
                    ->get();
    
    
                View::share('job_registers_near_deadline', $job_registers_near_deadline);
    
                return $next($request);
            } else {
                View::share('job_registers_near_deadline', []);
                return $next($request);
            }
        }
       
    }
}
