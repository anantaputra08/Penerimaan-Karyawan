<?php

namespace App\Http\Controllers;

use App\Models\Loker;
use App\Models\Department;
use App\Models\Position;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LokerController extends Controller
{
    public function index()
    {
        $lokers = Loker::with('department', 'position')->get();
        return view('lokers.index', compact('lokers'));
    }

    public function opening()
    {
        $lokers = Loker::with(['department', 'position'])
            ->get()
            ->map(function ($loker) {
                $loker->current_applicants_count = $loker->current_applicants_count;
                return $loker;
            });

        return view('lokersOpening', compact('lokers'));
    }

    public function show($id)
    {
        $loker = Loker::with(['department', 'position'])->findOrFail($id);
        return view('lokersDetail', compact('loker'));
    }

    public function create()
    {
        $departments = Department::all();
        $positions = Position::all(); // Mengambil semua posisi
        return view('lokers.create', compact('departments', 'positions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'max_applicants' => 'required|integer|min:1',
            'salary' => 'required|numeric',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'statement_letter' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $data = $request->except(['photo', 'statement_letter']);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        if ($request->hasFile('statement_letter')) {
            $data['statement_letter'] = $request->file('statement_letter')->store('statements', 'public');
        }

        Loker::create($data);

        return redirect()->route('lokers.index')->with('success', 'Loker created successfully.');
    }

    public function edit(Loker $loker)
    {
        $departments = Department::all();
        $positions = Position::all();
        return view('lokers.edit', compact('loker', 'departments', 'positions'));
    }

    public function update(Request $request, Loker $loker)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'max_applicants' => 'required|integer|min:1',
            'salary' => 'required|numeric',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'statement_letter' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $data = $request->except(['photo', 'statement_letter']);

        if ($request->hasFile('photo')) {
            if ($loker->photo) {
                Storage::delete('public/' . $loker->photo);
            }
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        if ($request->hasFile('statement_letter')) {
            if ($loker->statement_letter) {
                Storage::delete('public/' . $loker->statement_letter);
            }
            $data['statement_letter'] = $request->file('statement_letter')->store('statements', 'public');
        }

        $loker->update($data);

        return redirect()->route('lokers.index')->with('success', 'Loker updated successfully.');
    }

    public function destroy(Loker $loker)
    {
        if ($loker->photo) {
            Storage::delete('public/' . $loker->photo);
        }

        if ($loker->statement_letter) {
            Storage::delete('public/' . $loker->statement_letter);
        }

        $loker->delete();

        return redirect()->route('lokers.index')->with('success', 'Loker deleted successfully.');
    }

    public function showApplyForm($id)
    {
        $loker = Loker::findOrFail($id);
        return view('applyForm', compact('loker'));
    }

    public function submitApplication(Request $request, $id)
    {
        $request->validate([
            'application_file' => 'required|mimes:pdf|max:2048', // Max 2MB
        ]);

        $loker = Loker::findOrFail($id);

        $alreadyApplied = JobApplication::where('user_id', auth()->id())
            ->where('lokers_id', $loker->id)
            ->exists();

        if ($alreadyApplied) {
            return redirect()->route('lokers.show', $id)->with('error', 'You have already applied for this job.');
        }

        $applicationCount = JobApplication::where('lokers_id', $loker->id)->count();

        if ($applicationCount >= $loker->max_applicants) {
            return redirect()->route('lokers.show', $id)->with('error', 'This job vacancy is already full.');
        }

        if ($request->hasFile('application_file')) {
            $file = $request->file('application_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('applications', $fileName, 'public');
        }

        JobApplication::create([
            'user_id' => auth()->id(),
            'lokers_id' => $loker->id,
            'applied_at' => now(),
            'application_file' => $filePath ?? null,
        ]);

        return redirect()->route('lokers.show', $id)->with('success', 'Your application has been submitted successfully.');
    }


    public function getPositionsByDepartment(Request $request)
    {
        $departmentId = $request->query('department_id');

        if (!$departmentId) {
            return response()->json([], 400);
        }

        $positions = Position::where('department_id', $departmentId)->get();

        return response()->json($positions);
    }
}
