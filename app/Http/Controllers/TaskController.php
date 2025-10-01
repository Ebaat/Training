<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // عرض كل المهام
    public function index()
    {
        $tasks = Auth::user()->tasks; // بجيب المهام بتاعت اليوزر اللي عامل تسجيل دخول
        return response()->json($tasks, 200);
    }

    // إنشاء مهمة جديدة
public function store(StoreTaskRequest $request)
{
   $user_id=Auth::user()->id; // بجيب اليوزر كامل لو حبيت
   $validatedData = $request->validated();
    $validatedData['user_id'] = $user_id; // بضيف اليوزر اي
     $task = Task::create($validatedData);

    return response()->json($task, 201);
}


    // عرض مهمة واحدة
    public function show($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json($task, 200);
    }

    // تحديث مهمة
  // تحديث مهمة
public function update(StoreTaskRequest $request, $id)
{
    $task = Task::find($id);

    if (!$task) {
        return response()->json(['message' => 'Task not found'], 404);
    }

    // جبت اليوزر من التوكن
    $userId = Auth::id();

    // أتأكد إن التاسك فعلاً تبع اليوزر ده
    if ($task->user_id !== $userId) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    $task->update($request->validated());

    return response()->json([
        'message' => 'Task updated successfully',
        'task'    => $task
    ], 200);
}


    // حذف مهمة
    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->delete();

        return response()->json(null, 204);
    }

       public function getTaskUser($id)
       {
              $user = Task::find($id)->user;
              return response()->json($user, 200);
       }
}
