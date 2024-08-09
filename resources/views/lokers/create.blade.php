@extends('layouts.admin')

@section('main-content')
<h1>Create Loker</h1>

<form action="{{ route('lokers.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="name">Loker Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>

    <div class="form-group">
        <label for="department">Department</label>
        <select class="form-control" id="department" name="department_id" required>
            <option value="">Select Department</option>
            @foreach ($departments as $department)
            <option value="{{ $department->id }}">{{ $department->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="position">Position</label>
        <select class="form-control" id="position" name="position_id" required>
            <option value="">Select Position</option>
        </select>
    </div>

    <div class="form-group">
        <label for="max_applicants">Max Applicants</label>
        <input type="number" class="form-control" id="max_applicants" name="max_applicants" required>
    </div>

    <div class="form-group">
        <label for="salary">Salary</label>
        <input type="number" step="0.01" class="form-control" id="salary" name="salary" required>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
    </div>

    <div class="form-group">
        <label for="photo">Photo</label>
        <input type="file" class="form-control-file" id="photo" name="photo">
    </div>

    <div class="form-group">
        <label for="statement_letter">Statement Letter (Optional)</label>
        <input type="file" class="form-control-file" id="statement_letter" name="statement_letter">
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
</form>
@endsection

@section('scripts')
<script>
    document.getElementById('department').addEventListener('change', function() {
        var departmentId = this.value;
        var positionSelect = document.getElementById('position');

        console.log(`Fetching positions for department ID: ${departmentId}`);

        fetch(`{{ route('positions.byDepartment') }}?department_id=${departmentId}`)
            .then(response => response.json())
            .then(data => {
                console.log('Positions data:', data);
                positionSelect.innerHTML = '<option value="">Select Position</option>';
                data.forEach(position => {
                    positionSelect.innerHTML += `<option value="${position.id}">${position.name}</option>`;
                });
            })
            .catch(error => console.error('Error fetching positions:', error));
    });
</script>
@endsection
