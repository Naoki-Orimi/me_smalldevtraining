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
        // 最近のタスクを取得（created_atが一番新しい5件のみ）
        $recentTasks = Task::getRecentTasks(5);
        
        // ステータス別のタスク数を取得
        $taskCounts = [
            'not_started' => Task::getTasksByStatus(Task::STATUS_NOT_STARTED)->count(),
            'in_progress' => Task::getTasksByStatus(Task::STATUS_IN_PROGRESS)->count(),
            'on_hold' => Task::getTasksByStatus(Task::STATUS_ON_HOLD)->count(),
            'completed' => Task::getTasksByStatus(Task::STATUS_COMPLETED)->count(),
        ];

        // 総タスク数を計算
        $totalTasks = array_sum($taskCounts);

        return view('home', compact('recentTasks', 'taskCounts', 'totalTasks'));
    }
}
