<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $term = request('term', null);

        $data = Customer::latest('id')
        ->when($term, function($query, $term){
            $query->whereAny([
                'name',
                'email',
                'phone',
                'address'
            ], 'LIKE', "%$term%");
        })
        ->paginate(5);
        
        return response()->json($data);
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

            $customer = Customer::query()->create($data);

            return response()->json($data, 200);

        } catch (\Throwable $th) {

            if (!empty($data['avarta']) && Storage::exists($data['avatar'])) {
                Storage::delete($data['avarta']);
            }

            return response()->json([
                'msg' => 'Fail'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, string $id)
    {
        $data = $request->validated();

        $customer = Customer::find($id);

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

            return response()->json($data, 200);

        } catch (\Throwable $th) {

            if (!empty($data['avarta']) && Storage::exists($data['avatar'])) {
                Storage::delete($data['avarta']);
            }

            return response()->json([
                'msg' => 'Fail'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
