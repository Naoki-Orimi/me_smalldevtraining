@extends('layouts.app')

@section('title', 'タスク詳細 - タスク管理システム')

@section('content')
<div class="px-4 sm:px-0">
    <!-- セッションアラート -->
    <x-session-alerts />
    
    <!-- ヘッダー -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">タスク詳細</h2>
                <p class="text-gray-600">タスクの詳細情報を確認できます。</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('tasks.index') }}" class="btn-secondary">
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    一覧に戻る
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

    <!-- タスク詳細 -->
    <div class="max-w-4xl mx-auto">
        <div class="card">
            <!-- タスクヘッダー -->
            <div class="border-b border-gray-200 pb-6 mb-6">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $task->title }}</h3>
                        
                        <!-- ステータスと優先度 -->
                        <div class="flex items-center space-x-3 mb-4">
                            <!-- ステータスバッジ -->
                            @php
                                $statusKey = match($task->status) {
                                    0 => 'not_started',
                                    1 => 'in_progress', 
                                    2 => 'on_hold',
                                    3 => 'completed',
                                    default => 'not_started'
                                };
                                $status = $statusInfo[$statusKey];
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($status['color'] === 'gray') bg-gray-100 text-gray-800
                                @elseif($status['color'] === 'blue') bg-blue-100 text-blue-800
                                @elseif($status['color'] === 'yellow') bg-yellow-100 text-yellow-800
                                @else bg-green-100 text-green-800
                                @endif">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $status['icon'] }}"></path>
                                </svg>
                                {{ $status['title'] }}
                            </span>
                            
                            <!-- 優先度バッジ -->
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
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
                    
                    <!-- アクションボタン -->
                    <div class="flex space-x-2">
                        <button class="btn-secondary">
                            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            編集
                        </button>
                        <button class="btn-danger" disabled>
                            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            削除
                        </button>
                    </div>
                </div>
            </div>

            <!-- タスク情報 -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- メイン情報 -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- 説明 -->
                    @if($task->description)
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-3">説明</h4>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $task->description }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- 進捗 -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-3">進捗</h4>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700">進捗率</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $task->progress }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-blue-600 h-3 rounded-full transition-all duration-300" style="width: {{ $task->progress }}%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- コメント履歴 -->
                    @if($task->comments && count($task->comments) > 0)
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-3">コメント履歴</h4>
                            <div class="space-y-4">
                                @foreach($task->comments as $comment)
                                    <div class="border-l-4 border-blue-200 pl-4 py-2">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-sm font-medium text-gray-900">{{ $comment['user_id'] ?? '不明' }}</span>
                                            <span class="text-xs text-gray-500">{{ isset($comment['created_at']) ? \Carbon\Carbon::parse($comment['created_at'])->format('Y/m/d H:i') : '' }}</span>
                                        </div>
                                        <p class="text-sm text-gray-700">{{ $comment['comment'] ?? '' }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- サイドバー情報 -->
                <div class="space-y-6">
                    <!-- 基本情報 -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-3">基本情報</h4>
                        <div class="space-y-3">
                            <div class="flex items-center text-sm">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="text-gray-600">作成者:</span>
                                <span class="ml-2 font-medium">{{ $task->creator->name }}</span>
                            </div>
                            
                            @if($task->due_date)
                                <div class="flex items-center text-sm">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-gray-600">期日:</span>
                                    <span class="ml-2 font-medium">{{ $task->due_date->format('Y年m月d日') }}</span>
                                    @if($task->due_date->isPast() && $task->status != 3)
                                        <span class="ml-2 text-red-500 text-xs">期限切れ</span>
                                    @endif
                                </div>
                            @endif
                            
                            <div class="flex items-center text-sm">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-gray-600">作成日:</span>
                                <span class="ml-2 font-medium">{{ $task->created_at->format('Y年m月d日 H:i') }}</span>
                            </div>
                            
                            <div class="flex items-center text-sm">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                <span class="text-gray-600">更新日:</span>
                                <span class="ml-2 font-medium">{{ $task->updated_at->format('Y年m月d日 H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- 担当者 -->
                    @if($task->assignee_ids && count($task->assignee_ids) > 0)
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-3">担当者</h4>
                            <div class="space-y-2">
                                @foreach($task->assignee_ids as $assigneeId)
                                    <div class="flex items-center text-sm">
                                        <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center mr-3">
                                            <span class="text-white text-xs font-medium">{{ substr($assigneeId, 0, 1) }}</span>
                                        </div>
                                        <span class="text-gray-700">ユーザーID: {{ $assigneeId }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- 添付ファイル -->
                    @if($task->attachment_url)
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-3">添付ファイル</h4>
                            <a href="{{ $task->attachment_url }}" target="_blank" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                </svg>
                                添付ファイルを開く
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
