<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::with('department')->get();
        return view('positions.index', compact('positions'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('positions.create', compact('departments'));
    }
    public function show($id)
    {
        $position = Position::findOrFail($id);
        return view('positions.show', compact('position'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
        ]);

        Position::create($request->all());

        return redirect()->route('positions.index')->with('success', 'Position created successfully.');
    }

    public function edit(Position $position)
    {
        $departments = Department::all();
        return view('positions.edit', compact('position', 'departments'));
    }

    public function update(Request $request, Position $position)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
        ]);

        $position->update($request->all());

        return redirect()->route('positions.index')->with('success', 'Position updated successfully.');
    }

    public function destroy(Position $position)
    {
        $position->delete();
        return redirect()->route('positions.index')->with('success', 'Position deleted successfully.');
    }
}
