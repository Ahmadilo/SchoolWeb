@extends('layouts.index')

@section("Modal")
    <form method="POST" action="{{ route('students.store') }}" class="needs-validation" novalidate>
        @csrf
        <div class="mb-3">
            <label for="Fullname" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="Fullname" name="Fullname" required maxlength="255">
            <div class="invalid-feedback">
            Please enter your full name.
            </div>
        </div>

        <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" maxlength="15">
            <div class="invalid-feedback">
            Maximum number of digits is 15.
            </div>
        </div>

        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select class="form-select" id="gender" name="gender" required>
            <option value="" selected disabled>Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="unselected">Unselected</option>
            </select>
            <div class="invalid-feedback">
            Please select gender.
            </div>
        </div>

        <div class="mb-3">
            <label for="Enrollment_type" class="form-label">Enrollment Type</label>
            <input type="text" class="form-control" id="Enrollment_type" name="Enrollment_type" required maxlength="50">
            <div class="invalid-feedback">
            Please enter enrollment type.
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <script>
        // Activate Bootstrap 5 validation
        (() => {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
            }, false)
        })
        })()
    </script>

@endsection

@section('content')
     @if ($errors->has('error'))
        <div class="alert alert-danger">
            {{ $errors->first('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
        Add Student
    </button>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css">

    <table id="StudentsTable" class="display">
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Phone Number</th>
                <th>Enrollment Type</th>
                <th>Gender</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr>
                    <td>{{ $student->person->Fullname }}</td>
                    <td>{{ $student->person->phone_number }}</td>
                    <td>{{ $student->EnrollmentType }}</td>
                    <td>{{ $student->person->gender }}</td>
                    <td> {{ $student->status }} </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>

    <script>
        new DataTable("#example");
        new DataTable('#StudentsTable');
    </script>

@endsection