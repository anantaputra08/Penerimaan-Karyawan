<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\User;
use App\Models\Loker;
use Illuminate\Http\Request;

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
        $users = User::count();

        // Number of available lokers
        $availableLokers = Loker::where('max_applicants', '>', function($query) {
            $query->selectRaw('COUNT(*)')
                ->from('job_applications')
                ->whereColumn('job_applications.lokers_id', 'lokers.id');
        })->count();

        // Number of lokers with maximum applicants
        $maxApplicantsLokers = Loker::whereHas('jobApplications', function($query) {
            $query->selectRaw('COUNT(*)')
                ->from('job_applications')
                ->groupBy('lokers_id')
                ->havingRaw('COUNT(*) >= max_applicants');
        })->count();

        // Percentage of job applications with pending status
        $totalJobApplications = JobApplication::count();
        $pendingJobApplications = JobApplication::where('status', 'pending')->count();
        $pendingPercentage = $totalJobApplications > 0 ? ($pendingJobApplications / $totalJobApplications) * 100 : 0;

        $widget = [
            'users' => $users,
            'availableLokers' => $availableLokers,
            'maxApplicantsLokers' => $maxApplicantsLokers,
            'pendingPercentage' => $pendingPercentage,
        ];

        return view('home', compact('widget'));
    }
}
