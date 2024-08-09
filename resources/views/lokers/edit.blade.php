@extends('layouts.admin')

@section('main-content')
    <h1>Edit Loker</h1>

    <form action="{{ route('lokers.update', $loker->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Loker Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $loker->name }}" required>
        </div>

        <div class="form-group">
            <label for="department">Department</label>
            <select class="form-control" id="department" name="department_id" required>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}" {{ $department->id == $loker->department_id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="position">Position</label>
            <select class="form-control" id="position" name="position_id" required>
                <!-- Positions will be loaded via JavaScript -->
            </select>
        </div>

        <div class="form-group">
            <label for="max_applicants">Max Applicants</label>
            <input type="number" class="form-control" id="max_applicants" name="max_applicants" value="{{ $loker->max_applicants }}" required>
        </div>

        <div class="form-group">
            <label for="salary">Salary</label>
            <input type="number" step="0.01" class="form-control" id="salary" name="salary" value="{{ $loker->salary }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required>{{ $loker->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="photo">Photo</label>
            <input type="file" class="form-control-file" id="photo" name="photo">
            @if ($loker->photo)
                <img src="{{ Storage::url($loker->photo) }}" alt="Photo" width="100">
            @endif
        </div>

        <div class="form-group">
            <label for="statement_letter">Statement Letter (Optional)</label>
            <input type="file" class="form-control-file" id="statement_letter" name="statement_letter">
            @if ($loker->statement_letter)
                <a href="{{ Storage::url($loker->statement_letter) }}" target="_blank">View Statement Letter</a>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection

@section('scripts')
    <script>
        document.getElementById('department').addEventListener('change', function () {
            var departmentId = this.value;
            var positionSelect = document.getElementById('position');

            fetch(`/positions?department_id=${departmentId}`)
                .then(response => response.json())
                .then(data => {
                    positionSelect.innerHTML = '<option value="">Select Position</option>';
                    data.forEach(position => {
                        positionSelect.innerHTML += `<option value="${position.id}" ${position.id == '{{ $loker->position_id }}' ? 'selected' : ''}>${position.name}</option>`;
                    });
                });
        }).dispatchEvent(new Event('change'));
    </script>
@endsection
