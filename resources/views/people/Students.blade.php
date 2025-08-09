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
        <x-alert type="error" message="{{ $errors->first('error') }}"></x-alert>
    @endif

    @if (session('success'))
        <x-alert type="success" message="{{ session('success') }}"></x-alert>
    @endif

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
        Add Student
    </button>

    <!-- Modal -->
    <div class="modal fade" id="StudentModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">عنوان المودال</h5>
            <button id="CloseEdit" type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <!-- صف البطاقة: صورة + معلومات -->
                <div class="row mb-4 align-items-center">
                <!-- صورة الطالب -->
                    <div class="col-4 text-center">
                        <img src="https://via.placeholder.com/150" class="img-fluid rounded" alt="Student Image">
                    </div>
                    
                    <!-- معلومات الطالب -->
                    <div id="StudentCard" class="col-8">
                        <h5>Full Name: <strong id="FullName">Ahmad Aden</strong></h5>
                        <p id="Phone">Phone: 3847584</p>
                        <p id="EnrollmentType"></p>
                        <p id="Gender">Gender: Male</p>
                        <p id="Status">Status: Active</p>
                    </div>
                    <div id="StudentEditForm" class="col-8" style="display: none;">
                        <form action="{{ route('students.update') }}" method="POST">
                            @method('PUT')
                            @csrf
                            <input id="StudentID" type="hidden" name="id" value="">
                            <div class="mb-3">
                                <label for="Fullname" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="FullnameInput" name="Fullname" value="" required maxlength="255">
                            </div>
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="phoneNumberInput" name="phone_number" value="" maxlength="15">
                            </div>
                            <div class="mb-3">
                                 <label for="gender" class="form-label">Gender</label>
                                <select class="form-select" id="genderInput" name="gender" required>
                                    <option value="" disabled>Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="unselected">Unselected</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="Enrollment" class=" form-label">Enrollment Type</label>
                                <select name="Enrollment_type" id="Enrollment" class=" form-select">
                                    <option value="Normal Student" selected>Normal Student</option>
                                </select>
                            </div>
                            <div class="mb-3"><button class="btn btn-success" type="submit">Update</button></div>
                        </form>
                    </div>
                </div>

                <!-- صف الأزرار -->
                <div class="row text-center">
                <div class="col">
                    <button id="Edit" class="btn btn-warning w-100">Edit</button>
                </div>
                <div class="col">
                    <button id="Delete" data-bs-toggle="modal" data-bs-target="#confirmModal" class="btn btn-danger w-100">Delete</button>
                </div>
                <div class="col">
                    <button class="btn btn-success w-100">Profile</button>
                </div>
                </div>
            </div>
        </div>

        {{-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
            <button type="button" class="btn btn-primary">حفظ</button>
        </div> --}}
        </div>
    </div>
    </div>


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
                <tr data-id="{{ $student->id }}" data-bs-toggle="modal" data-bs-target="#StudentModal">
                    <td>{{ $student->person->Fullname }}</td>
                    <td>{{ $student->person->phone_number }}</td>
                    <td>{{ $student->EnrollmentType }}</td>
                    <td>{{ $student->person->gender }}</td>
                    <td> {{ $student->status }} </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="confirmModalLabel">تحذير</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    هل أنت متأكد أنك تريد القيام بهذه العملية؟
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="button" class="btn btn-danger" id="confirmBtn">موافق</button>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('students.destroy') }}" method="POST" style="display: none;">
        @method('DELETE')
        @csrf
        <input type="number" name="id" id="deleteid">
        <button id="btn-delete" type="submit">Submt</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>

    <script>
        new DataTable('#StudentsTable');

        document.querySelectorAll('#StudentsTable tbody tr').forEach(row => {
            row.addEventListener('click', () => {
                const id = row.getAttribute('data-id');

                // ✅ التصحيح هنا
                document.getElementById('StudentCard').setAttribute('data-id', id);

                console.log('is move from here');

                document.getElementById('FullName').innerText = row.cells[0].innerText;
                document.getElementById('Phone').innerText = 'Phone: ' + row.cells[1].innerText;
                document.getElementById('EnrollmentType').innerText = 'Enrollment Type: ' + row.cells[2].innerText;
                document.getElementById('Gender').innerText = 'Gender: ' + row.cells[3].innerText;
                document.getElementById('Status').innerText = 'Status: ' + row.cells[4].innerText;
            });
        });


        document.getElementById("Edit").addEventListener('click', () => {
            const StudentCard = document.getElementById('StudentCard');
            
            StudentCard.style.display = 'none';

            const StudentEditForm = document.getElementById('StudentEditForm');

            StudentEditForm.style.display = 'block';

            document.getElementById('StudentID').value = document.getElementById('StudentCard').getAttribute('data-id');

            document.getElementById('FullnameInput').value = document.getElementById('FullName').innerText;
        
            document.getElementById('phoneNumberInput').value = document.getElementById('Phone').innerText;
        
            const select = document.getElementById('genderInput');
            const genderValue = document.getElementById('Gender').innerText.toLowerCase();

            let Value = '';
            if(typeof genderValue === 'string')
            {
                console.log("it is string");
                console.log(genderValue);   
                Value = genderValue.split(' ')[1].toLowerCase();
            }
            console.log(Value);
            Array.from(select.options).forEach(option => {
                if (option.innerText.toLowerCase() === Value) {
                    option.selected = true;
                }
            });
        });


        document.getElementById("CloseEdit").addEventListener('click', () => {
            const StudentCard = document.getElementById('StudentCard');
            
            StudentCard.style.display = 'block';

            const StudentEditForm = document.getElementById('StudentEditForm');

            StudentEditForm.style.display = 'none';
        });

        document.getElementById('Delete').addEventListener('click', () => {
            const id = StudentCard.getAttribute('data-id');
            
            document.getElementById('deleteid').value = id;

            document.getElementById('confirmBtn').addEventListener('click', () => {
                document.getElementById('btn-delete').click();
            })
        });
    </script>

@endsection