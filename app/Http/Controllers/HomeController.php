<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Models\FoodCollection;
use App\Models\HumberSetting;
use App\Models\Jobcard;
use App\Models\MeatAllocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $settings = HumberSetting::where('id', 1)->first();

            $food_count = 0;
            $meat_count = 0;
            $jobcards = Jobcard::all();

            foreach ($jobcards as $job) {
                if ($job->remaining > 0 && $job->card_type == 'Food') {
                    $food_count += $job->remaining;
                } else if ($job->remaining > 0 && $job->card_type == 'Meat') {
                    $meat_count += $job->remaining;
                }
            }

            $total = $food_count + $meat_count;

            $jobcards = DB::table('jobcards')->orderBy('created_at', 'desc')->limit(3)->get();

            return view('home', compact('settings', 'jobcards', 'food_count', 'meat_count', 'total'));
        }

        if ($user->hasRole('user')) {
            $user = Auth::user();
            $meatallocations = MeatAllocation::where('paynumber', $user->paynumber)->latest()->get();
            $allocations = Allocation::where([['paynumber', $user->paynumber], ['status', 'not collected']])->latest()->get();
            $f_count = Allocation::where([['paynumber', $user->paynumber], ['status', 'not collected']])->count();
            $m_count = MeatAllocation::where([['paynumber', $user->paynumber], ['status', 'not collected']])->count();
            $settings = HumberSetting::where('id', 1)->first();

            return view('pages.user.home', compact('meatallocations', 'allocations', 'settings', 'f_count', 'm_count'));
        }

        if ($user->hasRole('hamperissuer')) {
            $user = Auth::user();
            $meatallocations = MeatAllocation::where('paynumber', $user->paynumber)->latest()->get();
            $allocations = Allocation::where([['paynumber', $user->paynumber], ['status', 'not collected']])->latest()->get();
            $f_count = Allocation::where([['paynumber', $user->paynumber], ['status', 'not collected']])->count();
            $m_count = MeatAllocation::where([['paynumber', $user->paynumber], ['status', 'not collected']])->count();
            $settings = HumberSetting::where('id', 1)->first();

            return view('pages.datacapture.home', compact('meatallocations', 'allocations', 'settings', 'f_count', 'm_count'));
        }

        if ($user->hasRole('datacapturer')) {
            $user = Auth::user();
            $meatallocations = MeatAllocation::where('paynumber', $user->paynumber)->latest()->get();
            $allocations = Allocation::where([['paynumber', $user->paynumber], ['status', 'not collected']])->latest()->get();
            $f_count = Allocation::where([['paynumber', $user->paynumber], ['status', 'not collected']])->count();
            $m_count = MeatAllocation::where([['paynumber', $user->paynumber], ['status', 'not collected']])->count();
            $settings = HumberSetting::where('id', 1)->first();

            return view('pages.datacapture.home', compact('meatallocations', 'allocations', 'settings', 'f_count', 'm_count'));
        }
    }

    public function unauthorized()
    {
        return view('unauthorized');
    }
}
