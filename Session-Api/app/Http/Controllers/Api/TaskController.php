<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($projectId)
    {
        $project = Project::find($projectId);
        return response()->json(['tasks' => $project->tasks]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $projectId)
    {
        // dd($request);
        // Validate dữ liệu
        $validatedData = $request->validate([
            'task_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:Chưa bắt đầu,Đang thực hiện,Hoàn thành',
        ]);


        try {
            $project = Project::find($projectId);

            $task = $project->tasks()->create($validatedData);

            

            return response()->json([
                'message' => 'Nhiệm vụ được tạo', 
                'task' => $task
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Có lỗi xảy ra khi tạo nhiệm vụ', 
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($projectId, $taskId)
    {
        $task = Task::where('project_id', $projectId)->find($taskId);
        return response()->json([
            'data'  => $task,
            'project_id'    => $projectId,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $projectId, $taskId)
    {
        // Validate dữ liệu
        $validatedData = $request->validate([
            'task_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:Chưa bắt đầu,Đang thực hiện,Hoàn thành',
        ]);

        try {
            $task = Task::where('project_id', $projectId)->find($taskId);
            $task->update($validatedData);
            return response()->json([
                'message' => 'Nhiệm vụ được cập nhật', 
                'task' => $task]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Có lỗi xảy ra khi cập nhật nhiệm vụ', 
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($projectId, $taskId)
    {
        try {
            $task = Task::where('project_id', $projectId)->find($taskId);
            $task->delete();
            return response()->json([
                'message' => 'Nhiệm vụ được xóa'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Có lỗi xảy ra khi xóa nhiệm vụ', 
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
