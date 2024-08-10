@extends('layouts.admin')

@section('main-content')
<div class="container">
    <h1>Job Application Detail</h1>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="card">
        <div class="card-header">
            Application #{{ $jobApplication->id }}
        </div>
        <div class="card-body">
            <h5 class="card-title">Job Title: {{ $jobApplication->loker->name }}</h5>
            <p class="card-text">Applicant: {{ $jobApplication->user->name }} {{ $jobApplication->user->last_name }}</p>
            <p class="card-text">Email: {{ $jobApplication->user->email }}</p>
            <p class="card-text">Phone: {{ $jobApplication->user->phone }}</p>
            <p class="card-text">Date of Birth: {{ $jobApplication->user->birth_date ? \Carbon\Carbon::parse($jobApplication->user->birth_date)->format('d M Y') : 'N/A' }}</p>
            <p class="card-text">Address: {{ $jobApplication->user->address }}</p>
            <p class="card-text">Education: {{ $jobApplication->user->education }}</p>
            <p class="card-text">Applied At: {{ $jobApplication->applied_at }}</p>
            <p class="card-text">Status: {{ $jobApplication->status }}</p>
            <p class="card-text">Application File:
                @if($jobApplication->application_file)
                <a href="{{ Storage::url($jobApplication->application_file) }}" target="_blank">View File</a>
                @else
                N/A
                @endif
            </p>
            <div class="mt-3">
                <a href="{{ route('job_applications.index') }}" class="btn btn-secondary">Back</a>
                <form action="{{ route('job_applications.update', $jobApplication->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="accepted">
                    <button type="submit" class="btn btn-success">Accept</button>
                </form>
                <form action="{{ route('job_applications.update', $jobApplication->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="rejected">
                    <button type="submit" class="btn btn-danger">Reject</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
