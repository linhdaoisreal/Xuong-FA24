<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['projects' => Project::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate dữ liệu
        $validatedData = $request->validate([
            'project_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
        ]);

        try {
            // Tạo project
            $project = Project::create($validatedData);
            return response()->json([
                'message' => 'Dự án được tạo thành công', 
                'project' => $project
            ], 201);
        } catch (\Exception $e) {
            // Xử lý lỗi
            return response()->json([
                'error' => 'Có lỗi xảy ra khi tạo dự án', 
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::findOrFail($id);
        return response()->json($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       // Validate dữ liệu
       $validatedData = $request->validate([
        'project_name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_date' => 'required|date',
    ]);

    try {
        $project = Project::findOrFail($id);
        $project->update($validatedData);
        return response()->json([
            'message' => 'Dự án được cập nhật', 
            'project' => $project
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Có lỗi xảy ra khi cập nhật dự án', 
            'message' => $e->getMessage()
        ], 500);
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Project::findOrFail($id)->delete();
            return response()->json([
                'message' => 'Dự án được xóa'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Có lỗi xảy ra khi xóa dự án', 
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
