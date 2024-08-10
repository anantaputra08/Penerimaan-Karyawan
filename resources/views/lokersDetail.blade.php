@extends('layouts.admin')
@section('main-content')
<h1>Detail Loker</h1>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="card">
    <div class="card-body">
        <h2 class="card-title">{{ $loker->name }}</h2>
        
        <div class="row mt-4">
            <div class="col-md-6">
                <p><strong>Department:</strong> {{ $loker->department->name }}</p>
                <p><strong>Position:</strong> {{ $loker->position->name }}</p>
                <p><strong>Max Applicants:</strong> {{ $loker->max_applicants }}</p>
                <p><strong>Salary:</strong> {{ number_format($loker->salary, 0, ',', '.') }}</p>
            </div>
            <div class="col-md-6">
                @if($loker->photo)
                    <img src="{{ asset('storage/' . $loker->photo) }}" alt="Loker Photo" class="img-fluid mb-3" style="max-height: 300px;">
                @else
                    <p>No photo available</p>
                @endif
            </div>
        </div>

        <div class="mt-4">
            <h4>Description:</h4>
            <p>{{ $loker->description }}</p>
        </div>

        @if($loker->statement_letter)
            <div class="mt-4">
                <h4>Statement Letter:</h4>
                <a href="{{ asset('storage/' . $loker->statement_letter) }}" class="btn btn-info" download>Download Statement Letter (PDF)</a>
            </div>
        @endif

        <div class="mt-4">
            <a href="{{ route('lokers.apply.form', $loker->id) }}" class="btn btn-primary">Apply for this Job</a>
            <a href="{{ route('lokers.opening') }}" class="btn btn-secondary mt-2">Kembali</a>
        </div>
    </div>
</div>
@endsection