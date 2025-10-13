<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * トップページを表示
     */
    public function index()
    {
        // タスク一覧を取得（削除されていないタスクのみ）
        $tasks = Task::getActiveTasks();
        
        // ステータス別のタスク数を取得
        $taskCounts = [
            'not_started' => Task::getTasksByStatus(Task::STATUS_NOT_STARTED)->count(),
            'in_progress' => Task::getTasksByStatus(Task::STATUS_IN_PROGRESS)->count(),
            'on_hold' => Task::getTasksByStatus(Task::STATUS_ON_HOLD)->count(),
            'completed' => Task::getTasksByStatus(Task::STATUS_COMPLETED)->count(),
        ];

        return view('home', compact('tasks', 'taskCounts'));
    }
}
