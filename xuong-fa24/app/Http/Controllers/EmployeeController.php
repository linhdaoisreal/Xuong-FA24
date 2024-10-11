<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Employee::latest('id')->paginate(5);
        $departments = Department::all();
        $managers = Manager::all();

        return view('employees.index', compact('data', 'departments', 'managers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        $managers = Manager::all();

        // dd($departments);    

        return view('employees.create', compact( 'departments', 'managers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'email' => ['required','max:150', 'email', Rule::unique('employees')],
            'phone' => 'required|max:15',
            'date_of_birth' => 'required',
            'hire_date' => 'required',
            'salary' => 'required',
            'is_active' => ['nullable', 'required', 'max:255', Rule::in(0,1)],
            'department_id' => 'required',
            'manager_id' => 'required',
            'address' => 'required',
            'profile_picture' => 'nullable|image|max:2048'
        ]);

        try {
            
            if($request->hasFile('profile_picture')){
                $binaryPicture = file_get_contents($data['profile_picture']);
                $data['profile_picture'] = $binaryPicture;
                // $data['profile_picture'] = Storage::put('employees', $request->file('avarta'));
            }

            Employee::query()->create($data);

            return redirect()
                ->route('employees.index')
                ->with('success', true);

        } catch (\Throwable $th) {

            if (!empty($data['profile_picture']) && Storage::exists($data['profile_picture'])) {
                Storage::delete($data['profile_picture']);
            }

            return redirect()
                ->route('employees.index')
                ->with('success', false)
                ->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $departments = Department::all();
        $managers = Manager::all();

        // dd($departments);    

        return view('employees.show', compact('employee', 'departments', 'managers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $departments = Department::all();
        $managers = Manager::all();

        // dd($departments);    

        return view('employees.edit', compact('employee', 'departments', 'managers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'email' => ['required','max:150', 'email', Rule::unique('employees')->ignore($employee->id)],
            'phone' => 'required|max:15',
            'date_of_birth' => 'required',
            'hire_date' => 'required',
            'salary' => 'required',
            'is_active' => ['nullable', 'required', 'max:255', Rule::in(0,1)],
            'department_id' => 'required',
            'manager_id' => 'required',
            'address' => 'required',
            'profile_picture' => 'nullable|image|max:2048'
        ]);

        try {

            $data['is_active'] ??= 0;

            if($request->hasFile('profile_picture')){
                $binaryPicture = file_get_contents($data['profile_picture']);
                $data['profile_picture'] = $binaryPicture;
                // $data['profile_picture'] = Storage::put('employees', $request->file('avarta'));
            }

            $employee->update($data);

            return back()
                ->with('success', true);

        } catch (\Throwable $th) {

            return redirect()
                ->route('employees.index')
                ->with('success', false)
                ->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        try {
            $employee->delete();

            return back()
                ->with('success', true);

        } catch (\Throwable $th) {
            return back()
                ->route('employees.index')
                ->with('success', false)
                ->with('error', $th->getMessage());
        }
    }

    public function forceDestroy(Employee $employee)
    {
        try {
            $employee->forceDelete();

            return back()
                ->with('success', true);

        } catch (\Throwable $th) {
            return back()
                ->route('employees.index')
                ->with('success', false)
                ->with('error', $th->getMessage());
        }
    }
}
