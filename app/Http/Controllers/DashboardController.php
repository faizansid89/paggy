<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Payment;
use App\Models\Products;
use App\Models\Purchases;
use App\Models\ReceiveItem;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
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
        $streams = Payment::where('stream_id', '!=', null)->get();
        $webinars = Payment::where('webinar_id', '!=', null)->get();
        $users = User::where('role_id', '!=', 0)->get();


//        $lastSevenDays = Payment::where('created_at', '>=', Carbon::now()->subDays(7))->get();

        $lastSevenDays = Payment::selectRaw('DATE(created_at) as date_part, COUNT(id) as total_payments, SUM(amount) as total_amount')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date_part')
            ->get();

        $currentMonthRecords = Payment::selectRaw('DATE(created_at) as date_part, COUNT(id) as total_payments, SUM(amount) as total_amount')
            ->whereMonth('created_at', '=', Carbon::now()->month)
            ->groupBy('date_part')
            ->get();

        $streamTotal = DB::table('payments')
            ->select('stream_id', DB::raw('SUM(amount) as total_amount'))
            ->where('stream_id', '!=', null)
            ->groupBy('stream_id')
            ->get();


        // Group by webinar_id
        $webinarTotal = DB::table('payments')
            ->select('webinar_id', DB::raw('SUM(amount) as total_amount'))
            ->where('webinar_id', '!=', null)
            ->groupBy('webinar_id')
            ->get();

        // Calculate total amount for both stream and webinar
        $totalAmount = $streamTotal->sum('total_amount') + $webinarTotal->sum('total_amount');


        // Calculate percentages
        if($totalAmount != 0){
            $streamPercentage = ($streamTotal->sum('total_amount') / $totalAmount) * 100;
            $webinarPercentage = ($webinarTotal->sum('total_amount') / $totalAmount) * 100;
        }
        else {
            $streamPercentage = 0;
            $webinarPercentage = 0;
        }

        // Output the results
        $percentGraphs = [
            'streamTotal' => $streamTotal->toArray(),
            'webinarTotal' => $webinarTotal->toArray(),
            'totalAmount' => $totalAmount,
            'Stream Percentage' => $streamPercentage,
            'Webinar Percentage' => $webinarPercentage,
        ];


        return view('dashboard', compact('streams', 'webinars', 'users', 'lastSevenDays', 'currentMonthRecords', 'percentGraphs'));
    }
}
