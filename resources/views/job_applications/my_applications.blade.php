
@extends('layouts.admin')

@section('main-content')
<div class="container">
    <h1>My Job Applications</h1>
    @if($jobApplications->isEmpty())
        <p>You have not applied for any jobs yet.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Application ID</th>
                    <th>Job Title</th>
                    <th>Applied At</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jobApplications as $application)
                    <tr>
                        <td>{{ $application->id }}</td>
                        <td>{{ $application->loker->name }}</td>
                        <td>{{ $application->applied_at }}</td>
                        <td>{{ ucfirst($application->status) }}</td>
                        <td>
                            <a href="{{ route('job_applications.detail', $application->id) }}" class="btn btn-info">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
