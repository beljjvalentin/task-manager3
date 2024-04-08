<?php

namespace App\Http\Controllers;

use App\Models\Task;

use App\Models\TaskCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        // Fetch all task categories
        $categories = TaskCategory::all();

        // Fetch all tasks
        $tasks = Task::all();

        // Initialize an empty array to store the grouped tasks
        $groupedTasks = [];

        // Populate the groupedTasks array with task categories and associated tasks
        foreach ($categories as $category) {
            $task_list = Task::where('category_id', $category->id)->get();
            $groupedTasks[] = [
                'name' => $category->name,
                'tasks' => $task_list
            ];
        }

        // Return the grouped tasks as a JSON response
        return response()->json($groupedTasks, 200);
    }

    /**
     * Store a newly created task in the database.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'date' => 'date_format:Y-m-d',
            'category_id' => 'exists:task_categories,id',
            'urgency' => 'integer|between:1,100',
            'user_id' => 'exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $task = Task::create($request->all());

        return response()->json(['task' => $task], 201);
    }

    /**
     * Display the specified task.
     *
     * @param Task $task
     * @return JsonResponse
     */
    public function show(Task $task): JsonResponse
    {
        return response()->json(['task' => $task], 200);
    }

    /**
     * Update the specified task in the database.
     *
     * @param Request $request
     * @param Task $task
     * @return JsonResponse
     */
    public function update(Request $request, Task $task): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'date' => 'date_format:Y-m-d',
            'category_id' => 'exists:task_categories,id',
            'urgency' => 'integer|between:1,100',
            'user_id' => 'exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $task->update($request->all());

        return response()->json(['task' => $task], 200);
    }

    /**
     * Remove the specified task from the database.
     *
     * @param Task $task
     * @return JsonResponse
     */
    public function destroy(Task $task): JsonResponse
    {
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully'], 200);
    }
}
