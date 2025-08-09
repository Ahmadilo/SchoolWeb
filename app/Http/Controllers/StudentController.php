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
            //Log::info('Creating a new student', ['data' => $validated]);
            // إنشاء الشخص
            $person = Person::create([
                'Fullname'      => $validated['Fullname'],
                'phone_number'  => $validated['phone_number'] ?? null,
                'gender'        => $validated['gender'],
            ]);

            //Log::info('Person created successfully', ['person_id' => $person->id]);

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
        return view('people.Students', compact('student'));
    }
    
    public function update(Request $request)
    {
        log::info("is arraive here");
        $validated = $request->validate([
            'id' => 'required',
            'Fullname'         => 'required|string|max:255',
            'phone_number'     => 'nullable|string|max:15',
            'gender'           => 'required|in:male,female,unselected',
            'Enrollment_type'  => 'nullable|string|max:50',
        ]);
        $student = Student::findOrFail($request->id);

        if($student === null) {
            return redirect()->route('students.index')->with('error', 'Student not found');
        }


        DB::beginTransaction();

        try
        {
            $person = Person::findOrFail($student->person_id);

            $person->FullName = $validated['Fullname'];
            $person->phone_number = $validated['phone_number'] ?? null;
            $person->gender = $validated['gender'] ?? null;

            $person->save();

            $student->EnrollmentType = $validated['Enrollment_type'];
            $student->save();

            DB::commit();

            return redirect()->route('students.index')->with('success','Update Student');
        }
        catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update student: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $student = Student::findOrFail($id);
        DB::beginTransaction();

        try {
            $person = Person::findOrFail($student->person_id);
            $student->delete();
            $person->delete();

            DB::commit();
            return redirect()->route('students.index')->with('success', 'Student deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to delete student: ' . $e->getMessage()]);
        }
    }
}
