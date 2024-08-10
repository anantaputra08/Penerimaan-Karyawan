<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    public function index()
    {
        $jobApplications = JobApplication::with('user', 'loker')->get();
        return view('job_applications.index', compact('jobApplications'));
    }

    public function show($id)
    {
        $jobApplication = JobApplication::with('user', 'loker')->findOrFail($id);
        return view('job_applications.show', compact('jobApplication'));
    }

    public function update(Request $request, $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        $jobApplication->status = $request->input('status');
        $jobApplication->save();

        return redirect()->route('job_applications.show', $id)->with('success', 'Job application status updated successfully.');
    }

    public function myApplications()
    {
        $jobApplications = JobApplication::where('user_id', Auth::id())
            ->with('loker')  // Eager load related loker data
            ->get();
        return view('job_applications.my_applications', compact('jobApplications'));
    }

    public function detail($id)
    {
        $jobApplication = JobApplication::with(['user', 'loker', 'loker.department', 'loker.position'])->findOrFail($id);
        return view('job_applications.detail', compact('jobApplication'));
    }
}
