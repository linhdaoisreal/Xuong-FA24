<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Passport;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index()
    {
        $data = Student::latest('id')->with(['classroom', 'passport'])->paginate(10);

        return view('students.index', compact('data'));
    }

    /**
     * Show the form for creating the resource.
     */
    public function create()
    {
        $classrooms = Classroom::all(); 

        return view('students.create', compact('classrooms'));
    }

    /**
     * Store the newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          =>   'required|max:200',
            'email'         =>   ['required', 'email', Rule::unique('students')],
            'classroom_id'  =>   'required'
        ]);

        try {
            Student::query()->create($data);
            return redirect()
                ->route('students.index')
                ->with('success', true);
        } catch (\Throwable $th) {
            return back()
                ->with('success', false)
                ->with('error', $th->getMessage());
        }
    }

    /**
     * Display the resource.
     */
    public function show(Student $student)
    {
        $student->load(['classroom', 'passport', 'subjects']);

        // dd($student->toArray());

        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the resource.
     */
    public function edit(Student $student)
    {
        $classrooms = Classroom::all();

        return view('students.edit', compact('classrooms', 'student'));
    }

    /**
     * Update the resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        // dd($student);

        $data = $request->validate([
            'name'          =>   'required|max:200',
            'email'         =>   ['required', 'email', Rule::unique('students')->ignore($student->id)],
            'classroom_id'  =>   'required'
        ]);

        try {
            
            $student->update($data);

            return back()
                ->with('success', true);
        } catch (\Throwable $th) {
            return back()
                ->with('success', false)
                ->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the resource from storage.
     */
    public function destroy(Student $student)
    {
        try {
            $student->delete();

            return back()
                ->with('success', true);
        } catch (\Throwable $th) {
            return back()
                ->with('success', false)
                ->with('error', $th->getMessage());
        }
    }

    public function addPassport(Student $student){
        return view('students.addPassport', compact('student'));
    }

    public function storePassport(Request $request){
        $data = $request->validate([
            'student_id' => 'required|exists:students,id', // Kiểm tra trường 'student_id' tồn tại trong bảng 'students'
            'passport_number' => 'required|max:20|unique:passports,passport_number', // Kiểm tra trường passport_number duy nhất
            'issued_date' => 'required|date|date_format:Y-m-d', // Kiểm tra định dạng ngày
            'expiry_date' => 'required|date|after:issued_date', // Kiểm tra expiry_date phải sau issued_date
        ]);
    
        // Tiến hành lưu dữ liệu
        // Passport::create($data);

        try {
            Passport::query()->create($data);
            return redirect()
                ->route('students.index')
                ->with('success', true);
        } catch (\Throwable $th) {
            return back()
                ->with('success', false)
                ->with('error', $th->getMessage());
        }
    }

    public function addSubjects(Student $student){
        return view('students.addPassport', compact('student'));
    }

    public function storeSubjects(Request $request){
        $data = $request->validate([
            'student_id' => 'required|exists:students,id', // Kiểm tra trường 'student_id' tồn tại trong bảng 'students'
            'passport_number' => 'required|max:20|unique:passports,passport_number', // Kiểm tra trường passport_number duy nhất
            'issued_date' => 'required|date|date_format:Y-m-d', // Kiểm tra định dạng ngày
            'expiry_date' => 'required|date|after:issued_date', // Kiểm tra expiry_date phải sau issued_date
        ]);
    
        // Tiến hành lưu dữ liệu
        // Passport::create($data);

        try {
            Passport::query()->create($data);
            return redirect()
                ->route('students.index')
                ->with('success', true);
        } catch (\Throwable $th) {
            return back()
                ->with('success', false)
                ->with('error', $th->getMessage());
        }
    }
}
