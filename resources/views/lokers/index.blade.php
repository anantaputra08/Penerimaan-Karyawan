@extends('layouts.admin')

@section('main-content')
    <h1>Lokers</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('lokers.create') }}" class="btn btn-primary">Add Loker</a>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Name</th>
                <th>Department</th>
                <th>Position</th>
                <th>Max Applicants</th>
                <th>Salary</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lokers as $loker)
                <tr>
                    <td>{{ $loker->name }}</td>
                    <td>{{ $loker->department->name }}</td>
                    <td>{{ $loker->position->name }}</td>
                    <td>{{ $loker->max_applicants }}</td>
                    <td>{{ $loker->salary }}</td>
                    <td>{{ $loker->description }}</td>
                    <td>
                        <a href="{{ route('lokers.edit', $loker->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('lokers.destroy', $loker->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
