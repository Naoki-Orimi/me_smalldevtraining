@extends('layouts.app')

@section('title', 'タスク一覧 - タスク管理システム')

@section('content')
<div class="px-4 sm:px-0" id="app">
    <!-- セッションアラート -->
    <x-session-alerts />
    
    <!-- ヘッダー -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">タスク一覧</h2>
                <p class="text-gray-600">ステータス別にタスクを管理できます。</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('tasks.create') }}" class="btn-primary">
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    新しいタスク
                </a>
                <a href="{{ route('home') }}" class="btn-secondary">
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                    </svg>
                    ダッシュボード
                </a>
            </div>
        </div>
    </div>

    <!-- ステータス別タスクボード -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($tasksByStatus as $statusKey => $tasks)
            <!-- TODO: ハードコーディングされたステータスキーを設定ファイルやEnumに移行 -->
            <div class="bg-gray-50 rounded-lg p-4">
                <!-- ステータスヘッダー -->
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <!-- TODO: ハードコーディングされた色クラスを設定ファイルに移行 -->
                        @if($statusKey === 'not_started')
                            <div class="w-3 h-3 bg-gray-400 rounded-full mr-2"></div>
                            <h3 class="font-semibold text-gray-700">未着手</h3>
                        @elseif($statusKey === 'in_progress')
                            <div class="w-3 h-3 bg-blue-400 rounded-full mr-2"></div>
                            <h3 class="font-semibold text-gray-700">進行中</h3>
                        @elseif($statusKey === 'on_hold')
                            <div class="w-3 h-3 bg-yellow-400 rounded-full mr-2"></div>
                            <h3 class="font-semibold text-gray-700">保留</h3>
                        @elseif($statusKey === 'completed')
                            <div class="w-3 h-3 bg-green-400 rounded-full mr-2"></div>
                            <h3 class="font-semibold text-gray-700">完了</h3>
                        @endif
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="bg-white text-gray-600 text-xs px-2 py-1 rounded-full">{{ $tasks->count() }}</span>
                        <button class="text-gray-400 hover:text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- タスクカード -->
                <div class="space-y-3 min-h-[200px]">
                    @if($tasks->count() > 0)
                        @foreach($tasks as $task)
                            <div class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md transition-shadow cursor-pointer" 
                                 @click="openTaskModal({{ $task->id }})">
                                <!-- タスクヘッダー -->
                                <div class="flex items-start justify-between mb-2">
                                    <h4 class="text-sm font-medium text-gray-900 line-clamp-2">{{ $task->title }}</h4>
                                    <div class="flex items-center space-x-1 ml-2">
                                        <!-- 優先度バッジ -->
                                        <!-- TODO: ハードコーディングされた優先度の値とラベルをEnumや設定ファイルに移行 -->
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium
                                            @if($task->priority == 0) bg-gray-100 text-gray-800
                                            @elseif($task->priority == 1) bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            @if($task->priority == 0) 低
                                            @elseif($task->priority == 1) 中
                                            @else 高
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <!-- タスク説明 -->
                                @if($task->description)
                                    <p class="text-xs text-gray-600 mb-3 line-clamp-2">{{ $task->description }}</p>
                                @endif

                                <!-- タスク情報 -->
                                <div class="space-y-2">
                                    <!-- 期日 -->
                                    @if($task->due_date)
                                        <div class="flex items-center text-xs text-gray-500">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $task->due_date->format('Y/m/d') }}
                                        </div>
                                    @endif

                                    <!-- 進捗 -->
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-gray-500">進捗</span>
                                        <span class="font-medium">{{ $task->progress }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-1">
                                        <div class="bg-blue-600 h-1 rounded-full transition-all duration-300" style="width: {{ $task->progress }}%"></div>
                                    </div>

                                    <!-- 担当者数 -->
                                    @if($task->assignee_ids && count($task->assignee_ids) > 0)
                                        <div class="flex items-center text-xs text-gray-500">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                            </svg>
                                            {{ count($task->assignee_ids) }}人
                                        </div>
                                    @endif

                                    <!-- 添付ファイル -->
                                    @if($task->attachment_url)
                                        <div class="flex items-center text-xs text-blue-600">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                            </svg>
                                            添付あり
                                        </div>
                                    @endif

                                    <!-- 作成者と作成日 -->
                                    <div class="flex items-center justify-between text-xs text-gray-500 pt-2 border-t border-gray-100">
                                        <span>{{ $task->creator->name }}</span>
                                        <span>{{ $task->created_at->format('Y/m/d') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <p>タスクがありません</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- タスクモーダル -->
<div id="taskModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 z-50 hidden">
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
            <!-- ローディング状態 -->
            <div id="modalLoading" class="p-8 text-center">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                <p class="mt-2 text-gray-600">読み込み中...</p>
            </div>

            <!-- タスク内容 -->
            <div id="modalContent" class="p-6 hidden">
                <!-- ヘッダー -->
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h3 id="modalTitle" class="text-lg font-semibold text-gray-900 mb-2"></h3>
                        
                        <!-- ステータスと優先度 -->
                        <div class="flex items-center space-x-2">
                            <span id="modalStatus" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"></span>
                            <span id="modalPriority" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"></span>
                        </div>
                    </div>
                    
                    <button @click="closeModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- 説明 -->
                <div id="modalDescription" class="mb-4 hidden">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">説明</h4>
                    <p class="text-sm text-gray-600"></p>
                </div>

                <!-- 基本情報 -->
                <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                    <div>
                        <span class="text-gray-500">作成者:</span>
                        <span id="modalCreator" class="ml-1 font-medium"></span>
                    </div>
                    <div>
                        <span class="text-gray-500">進捗:</span>
                        <span id="modalProgress" class="ml-1 font-medium"></span>
                    </div>
                    <div id="modalDueDate" class="hidden">
                        <span class="text-gray-800 font-bold">期日:</span>
                        <span class="ml-1 font-bold text-gray-800"></span>
                    </div>
                    <div>
                        <span class="text-gray-500">作成日:</span>
                        <span id="modalCreatedAt" class="ml-1 font-medium"></span>
                    </div>
                </div>

                <!-- 進捗バー -->
                <div class="mb-6">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div id="modalProgressBar" class="bg-blue-600 h-2 rounded-full transition-all duration-300"></div>
                    </div>
                </div>

                <!-- アクションボタン -->
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button @click="closeModal" class="btn-secondary">
                        閉じる
                    </button>
                    <a id="modalDetailLink" href="#" class="btn-primary">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        詳細
                    </a>
                    <button class="btn-danger" disabled>
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        削除
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Vue.jsでモーダル機能を実装
document.addEventListener('DOMContentLoaded', function() {
    const { createApp } = Vue;

    createApp({
        data() {
            return {
                modalShow: false,
                selectedTask: null,
                modalLoading: false
            }
        },
        methods: {
            async openTaskModal(taskId) {
                this.modalShow = true;
                this.modalLoading = true;
                this.selectedTask = null;

                // モーダルを表示
                document.getElementById('taskModal').classList.remove('hidden');
                document.getElementById('modalLoading').classList.remove('hidden');
                document.getElementById('modalContent').classList.add('hidden');

                try {
                    const response = await fetch(`/api/tasks/${taskId}`);
                    if (response.ok) {
                        this.selectedTask = await response.json();
                        this.displayTaskData(this.selectedTask);
                    } else {
                        console.error('Failed to fetch task');
                        alert('タスクの取得に失敗しました。');
                        this.closeModal();
                    }
                } catch (error) {
                    console.error('Error fetching task:', error);
                    alert('タスクの取得に失敗しました。');
                    this.closeModal();
                } finally {
                    this.modalLoading = false;
                    document.getElementById('modalLoading').classList.add('hidden');
                    document.getElementById('modalContent').classList.remove('hidden');
                }
            },
            displayTaskData(task) {
                // タイトル
                document.getElementById('modalTitle').textContent = task.title;
                
                // ステータス
                const statusText = task.status === 0 ? '未着手' : 
                                  task.status === 1 ? '進行中' : 
                                  task.status === 2 ? '保留' : '完了';
                const statusClass = task.status === 0 ? 'bg-gray-100 text-gray-800' :
                                   task.status === 1 ? 'bg-blue-100 text-blue-800' :
                                   task.status === 2 ? 'bg-yellow-100 text-yellow-800' :
                                   'bg-green-100 text-green-800';
                const statusElement = document.getElementById('modalStatus');
                statusElement.textContent = statusText;
                statusElement.className = `inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${statusClass}`;
                
                // 優先度
                const priorityText = task.priority === 0 ? '低' : task.priority === 1 ? '中' : '高';
                const priorityClass = task.priority === 0 ? 'bg-gray-100 text-gray-800' :
                                     task.priority === 1 ? 'bg-yellow-100 text-yellow-800' :
                                     'bg-red-100 text-red-800';
                const priorityElement = document.getElementById('modalPriority');
                priorityElement.textContent = priorityText;
                priorityElement.className = `inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${priorityClass}`;
                
                // 説明
                const descriptionElement = document.getElementById('modalDescription');
                if (task.description) {
                    descriptionElement.querySelector('p').textContent = task.description;
                    descriptionElement.classList.remove('hidden');
                } else {
                    descriptionElement.classList.add('hidden');
                }
                
                // 作成者
                document.getElementById('modalCreator').textContent = task.creator ? task.creator.name : '不明';
                
                // 進捗
                document.getElementById('modalProgress').textContent = task.progress + '%';
                document.getElementById('modalProgressBar').style.width = task.progress + '%';
                
                // 期日
                const dueDateElement = document.getElementById('modalDueDate');
                if (task.due_date) {
                    const dueDate = new Date(task.due_date);
                    const now = new Date();
                    const isOverdue = dueDate < now;
                    
                    // 期限切れの場合は赤色、そうでなければ黒色
                    if (isOverdue) {
                        dueDateElement.querySelector('span:first-child').className = 'text-red-600 font-bold';
                        dueDateElement.querySelector('span:last-child').className = 'ml-1 font-bold text-red-600';
                    } else {
                        dueDateElement.querySelector('span:first-child').className = 'text-gray-800 font-bold';
                        dueDateElement.querySelector('span:last-child').className = 'ml-1 font-bold text-gray-800';
                    }
                    
                    dueDateElement.querySelector('span:last-child').textContent = task.due_date;
                    dueDateElement.classList.remove('hidden');
                } else {
                    dueDateElement.classList.add('hidden');
                }
                
                // 作成日
                document.getElementById('modalCreatedAt').textContent = task.created_at;
                
                // 詳細ボタンのリンク
                document.getElementById('modalDetailLink').href = `/tasks/detail/${task.id}`;
            },
            closeModal() {
                this.modalShow = false;
                this.selectedTask = null;
                this.modalLoading = false;
                document.getElementById('taskModal').classList.add('hidden');
            }
        },
        mounted() {
            // モーダル外クリックで閉じる
            document.getElementById('taskModal').addEventListener('click', (e) => {
                if (e.target === document.getElementById('taskModal')) {
                    this.closeModal();
                }
            });
        }
    }).mount('body');
});
</script>

@endsection