<?php

namespace App\Http\Controllers;

use App\Models\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    const PATH_VIEW = 'customers.';
    /**
     * Display a listing of the resource.
     */
    public function __construct()  
    {  
        $this->middleware('checkEmployee')->only(['index','show']);  
        $this->middleware('checkAdmin')->only([ 'store', 'edit', 'update', 'destroy']);  
    }
    
    public function index()
    {
        $data = Customer::latest('id')->paginate(5);

        return view(self::PATH_VIEW.__FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        

        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|max:255',
            'address'   => 'required|max:255',
            'avarta'    => 'nullable|image|max:2048',
            'phone'     => ['required', 'string', 'max:20', Rule::unique('customers')],
            'email'     => ['required', 'email', 'max:255'],
            'is_active' => ['nullable', 'required', 'max:255', Rule::in(0,1)]
        ]);

        try {
            
            if($request->hasFile('avarta')){
                $data['avarta'] = Storage::put('customers', $request->file('avarta'));
            }

            Customer::query()->create($data);

            return redirect()
                ->route('customers.index')
                ->with('success', true);

        } catch (\Throwable $th) {

            if (!empty($data['avarta']) && Storage::exists($data['avatar'])) {
                Storage::delete($data['avarta']);
            }

            return back()
                ->route('customers.index')
                ->with('success', false)
                ->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('customer'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('customer'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'name'      => 'required|max:255',
            'address'   => 'required|max:255',
            'avarta'    => 'nullable|image|max:2048',
            'phone'     => ['required', 'string', 'max:20', Rule::unique('customers')->ignore($customer->id)],
            'email'     => ['required', 'email', 'max:255'],
            'is_active' => ['nullable', 'max:255', 'Rule::in(0,1)']
        ]);

        try {

            $data['is_active'] ??= 0;   
            
            if($request->hasFile('avarta')){
                $data['avarta'] = Storage::put('customers', $request->file('avarta'));
            }

            $currentAvarta = $customer->avarta;

            $customer->update($data);

            if($request->hasFile('avarta') && !empty($currentAvarta) && Storage::exists($currentAvarta)){
                Storage::delete($currentAvarta);
            }

            return back()
                ->with('success', true);

        } catch (\Throwable $th) {

            if (!empty($data['avarta']) && Storage::exists($data['avatar'])) {
                Storage::delete($data['avarta']);
            }

            return back()
                ->route('customers.index')
                ->with('success', false)
                ->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();

            return back()
                ->with('success', true);

        } catch (\Throwable $th) {
            return back()
                ->route('customers.index')
                ->with('success', false)
                ->with('error', $th->getMessage());
        }
    }

    public function forceDestroy(Customer $customer)
    {
        try {
            $customer->forceDelete();

            if (!empty($customer->avarta) && Storage::exists($customer->avatar)) {
                Storage::delete($customer->avarta);
            }

            return back()
                ->with('success', true);

        } catch (\Throwable $th) {
            return back()
                ->route('customers.index')
                ->with('success', false)
                ->with('error', $th->getMessage());
        }
    }
}
