<?php

namespace App\Http\Controllers;

use App\Models\Loker;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LokerController extends Controller
{
    public function index()
    {
        $lokers = Loker::with('department', 'position')->get();
        return view('lokers.index', compact('lokers'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('lokers.create', compact('departments'));
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
            $data['photo'] = $request->file('photo')->store('photos');
        }

        if ($request->hasFile('statement_letter')) {
            $data['statement_letter'] = $request->file('statement_letter')->store('statements');
        }

        Loker::create($data);

        return redirect()->route('lokers.index')->with('success', 'Loker created successfully.');
    }

    public function edit(Loker $loker)
    {
        $departments = Department::all();
        $positions = Position::where('department_id', $loker->department_id)->get();
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
                Storage::delete($loker->photo);
            }
            $data['photo'] = $request->file('photo')->store('photos');
        }

        if ($request->hasFile('statement_letter')) {
            if ($loker->statement_letter) {
                Storage::delete($loker->statement_letter);
            }
            $data['statement_letter'] = $request->file('statement_letter')->store('statements');
        }

        $loker->update($data);

        return redirect()->route('lokers.index')->with('success', 'Loker updated successfully.');
    }

    public function destroy(Loker $loker)
    {
        if ($loker->photo) {
            Storage::delete($loker->photo);
        }

        if ($loker->statement_letter) {
            Storage::delete($loker->statement_letter);
        }

        $loker->delete();

        return redirect()->route('lokers.index')->with('success', 'Loker deleted successfully.');
    }

    public function getPositions(Request $request)
    {
        $departmentId = $request->input('department_id');

        // Check if departmentId is present and valid
        if (is_null($departmentId)) {
            return response()->json([], 400); // Bad request if departmentId is missing
        }

        $positions = Position::where('department_id', $departmentId)->get();

        return response()->json($positions);
    }
}
