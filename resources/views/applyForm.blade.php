@extends('layouts.admin')
@section('main-content')
<h1>Apply for {{ $loker->name }}</h1>

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('lokers.apply.submit', $loker->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="application_file">Upload Your Application (PDF)</label>
                <input type="file" class="form-control-file" id="application_file" name="application_file" accept=".pdf" required>
                <a>
                    <i>Upload surat pernyataan anda!!</i>
                </a>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Submit Application</button>
        </form>
        <a href="{{ route('lokers.show', $loker->id) }}" class="btn btn-secondary mt-2">Cancel</a>
    </div>
</div>
@endsection