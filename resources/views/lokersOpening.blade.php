@extends('layouts.admin')

@section('main-content')
<h1>Lokers Opening</h1>
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="row">
    @foreach ($lokers as $loker)
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $loker->name }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ $loker->position->name }}</h6>
                <p class="card-text">Department: {{ $loker->department->name }}</p>
                <p class="card-text">Salary: Rp.{{ number_format($loker->salary, 2) }}</p>
                <p class="card-text">Max Applicants: {{ $loker->max_applicants }} ({{ $loker->current_applicants_count }})</p>
                <a href="{{ route('lokers.show', $loker->id) }}" class="btn btn-primary btn-sm">Lihat Detail</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
