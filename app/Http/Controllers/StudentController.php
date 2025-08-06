<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Person;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();

         // Debugging line to check the data
        return view('people.Students', compact('students'));
    }

    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $validated = $request->validate([
            'Fullname'         => 'required|string|max:255',
            'phone_number'     => 'nullable|string|max:15',
            'gender'           => 'required|in:male,female,unselected',
            'Enrollment_type'  => 'nullable|string|max:50',
        ]);

        DB::beginTransaction();

        try 
        {
            Log::info('Creating a new student', ['data' => $validated]);
            // إنشاء الشخص
            $person = Person::create([
                'Fullname'      => $validated['Fullname'],
                'phone_number'  => $validated['phone_number'] ?? null,
                'gender'        => $validated['gender'],
            ]);

            Log::info('Person created successfully', ['person_id' => $person->id]);

            // إنشاء الطالب المرتبط بالشخص
            Student::create([
                'person_id'        => $person->id,
                'EnrollmentType'  => $validated['Enrollment_type'],
            ]);

            DB::commit();

            return redirect()
                ->route('students.index')
                ->with('success', 'Student created successfully');

        } 
        catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withErrors(['error' => 'Failed to create student: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('people.show', compact('student'));
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('people.edit', compact('student'));
    }

    public function destore($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully');
    }
}
