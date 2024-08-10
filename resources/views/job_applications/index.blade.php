@extends('layouts.admin')

@section('main-content')
<div class="container">
    <h1>Job Applications</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Job Title</th>
                <th>Applied At</th>
                <th>Status</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jobApplications as $application)
            <tr>
                <td>{{ $application->id }}</td>
                <td>{{ $application->user->name }}</td>
                <td>{{ $application->loker->name }}</td>
                <td>{{ $application->applied_at }}</td>
                <td>{{ ucfirst($application->status) }}</td>
                <td>{{ $application->updated_at }}</td>
                <td>
                    <a href="{{ route('job_applications.show', $application->id) }}" class="btn btn-info">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
