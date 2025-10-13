<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * タスク一覧を表示
     */
    public function index()
    {
        // ステータス別にタスクを取得
        $tasksByStatus = [
            'not_started' => Task::getTasksByStatus(Task::STATUS_NOT_STARTED),
            'in_progress' => Task::getTasksByStatus(Task::STATUS_IN_PROGRESS),
            'on_hold' => Task::getTasksByStatus(Task::STATUS_ON_HOLD),
            'completed' => Task::getTasksByStatus(Task::STATUS_COMPLETED),
        ];

        // ステータス情報
        // TODO: ハードコーディングされたステータス情報を設定ファイルやEnumに移行
        $statusInfo = [
            'not_started' => [
                'title' => '未着手',
                'color' => 'gray',
                'icon' => 'M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'
            ],
            'in_progress' => [
                'title' => '進行中',
                'color' => 'blue',
                'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
            ],
            'on_hold' => [
                'title' => '保留',
                'color' => 'yellow',
                'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z'
            ],
            'completed' => [
                'title' => '完了',
                'color' => 'green',
                'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
            ],
        ];

        return view('tasks.index', compact('tasksByStatus', 'statusInfo'));
    }
}
