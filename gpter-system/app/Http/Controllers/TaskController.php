<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Http\Requests\TaskStoreRequest;
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

    /**
     * タスク作成フォームを表示
     */
    public function create()
    {
        // ユーザー一覧を取得（担当者選択用）
        $users = User::whereNull('deleted_at')->get();
        
        // ステータス選択肢
        $statusOptions = [
            Task::STATUS_NOT_STARTED => '未着手',
            Task::STATUS_IN_PROGRESS => '進行中',
            Task::STATUS_ON_HOLD => '保留',
            Task::STATUS_COMPLETED => '完了',
        ];

        // 優先度選択肢
        $priorityOptions = [
            Task::PRIORITY_LOW => '低',
            Task::PRIORITY_MEDIUM => '中',
            Task::PRIORITY_HIGH => '高',
        ];

        // 進捗率選択肢
        $progressOptions = [
            Task::PROGRESS_0 => '0%',
            Task::PROGRESS_25 => '25%',
            Task::PROGRESS_50 => '50%',
            Task::PROGRESS_75 => '75%',
            Task::PROGRESS_100 => '100%',
        ];

        return view('tasks.create', compact('users', 'statusOptions', 'priorityOptions', 'progressOptions'));
    }

    /**
     * タスク詳細を表示
     */
    public function show($id)
    {
        // タスク詳細を取得（Model領域で処理）
        $task = Task::getTaskDetail($id);
        
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

        return view('tasks.detail', compact('task', 'statusInfo'));
    }

    /**
     * タスク情報をAPIで取得（モーダル用）
     */
    public function apiShow($id)
    {
        try {
            // タスク情報を取得（Model領域で処理）
            $task = Task::getTaskForModal($id);
            
            // フォーマット済みの日付を含むレスポンス
            return response()->json([
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'status' => $task->status,
                'due_date' => $task->formatted_due_date,
                'priority' => $task->priority,
                'assignee_ids' => $task->assignee_ids,
                'creator_id' => $task->creator_id,
                'creator' => $task->creator,
                'progress' => $task->progress,
                'attachment_url' => $task->attachment_url,
                'created_at' => $task->formatted_created_at,
                'updated_at' => $task->formatted_updated_at,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'タスクが見つかりません'], 404);
        }
    }

    /**
     * 新しいタスクを保存
     */
    public function store(TaskStoreRequest $request)
    {
        try {
            // バリデーション済みのデータを取得
            $validatedData = $request->validated();
            
            // タスクを作成（Model領域で処理）
            $task = Task::create($validatedData);

            return redirect()->route('tasks.index')
                ->with('success', 'タスクが正常に作成されました。');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'タスクの作成中にエラーが発生しました。');
        }
    }
}
