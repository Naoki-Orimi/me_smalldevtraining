@extends('layouts.app')

@section('title', 'タスク一覧 - タスク管理システム')

@section('content')
<div class="px-4 sm:px-0">
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

    <!-- タスクボード -->
    <!-- TODO: ハードコーディングされたステータスキーを動的に取得するように変更 -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        @foreach(['not_started', 'in_progress', 'on_hold', 'completed'] as $statusKey)
            @php
                $status = $statusInfo[$statusKey];
                $tasks = $tasksByStatus[$statusKey];
            @endphp
            
            <!-- ステータスカラム -->
            <div class="bg-gray-50 rounded-lg p-4">
                <!-- カラムヘッダー -->
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-2">
                        <!-- TODO: ハードコーディングされた色クラスを動的に生成するように変更 -->
                        <div class="w-6 h-6 rounded-full flex items-center justify-center
                            @if($status['color'] === 'gray') bg-gray-200
                            @elseif($status['color'] === 'blue') bg-blue-200
                            @elseif($status['color'] === 'yellow') bg-yellow-200
                            @else bg-green-200
                            @endif">
                            <svg class="w-4 h-4 
                                @if($status['color'] === 'gray') text-gray-600
                                @elseif($status['color'] === 'blue') text-blue-600
                                @elseif($status['color'] === 'yellow') text-yellow-600
                                @else text-green-600
                                @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $status['icon'] }}"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900">{{ $status['title'] }}</h3>
                        <span class="bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded-full">{{ $tasks->count() }}</span>
                    </div>
                    <button class="text-gray-400 hover:text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                        </svg>
                    </button>
                </div>

                <!-- タスクカード -->
                <div class="space-y-3 min-h-[200px]">
                    @if($tasks->count() > 0)
                        @foreach($tasks as $task)
                            <div class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md transition-shadow cursor-pointer">
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
                                    <p class="text-xs text-gray-600 mb-3 line-clamp-2">{{ Str::limit($task->description, 80) }}</p>
                                @endif

                                <!-- タスクメタ情報 -->
                                <div class="space-y-2">
                                    <!-- 期日 -->
                                    @if($task->due_date)
                                        <div class="flex items-center text-xs text-gray-500">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $task->due_date->format('m/d') }}
                                            <!-- TODO: ハードコーディングされた完了ステータスの値(3)を定数に置き換え -->
                                            @if($task->due_date->isPast() && $task->status != 3)
                                                <span class="ml-1 text-red-500">期限切れ</span>
                                            @endif
                                        </div>
                                    @endif

                                    <!-- 進捗率 -->
                                    @if($task->progress > 0)
                                        <div class="flex items-center text-xs text-gray-500">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                            </svg>
                                            {{ $task->progress }}%
                                        </div>
                                    @endif

                                    <!-- 担当者 -->
                                    @if($task->assignee_ids && count($task->assignee_ids) > 0)
                                        <div class="flex items-center text-xs text-gray-500">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
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
                                </div>

                                <!-- 進捗バー -->
                                @if($task->progress > 0)
                                    <div class="mt-3">
                                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                                            <div class="bg-blue-600 h-1.5 rounded-full transition-all duration-300" style="width: {{ $task->progress }}%"></div>
                                        </div>
                                    </div>
                                @endif

                                <!-- タスクフッター -->
                                <div class="flex items-center justify-between mt-3 pt-2 border-t border-gray-100">
                                    <div class="flex items-center text-xs text-gray-500">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        {{ $task->creator->name }}
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        {{ $task->created_at->format('m/d') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- 空の状態 -->
                        <div class="text-center py-8">
                            <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <p class="mt-2 text-xs text-gray-500">タスクがありません</p>
                        </div>
                    @endif
                </div>

                <!-- カラムフッター -->
                <div class="mt-4 pt-3 border-t border-gray-200">
                    <a href="{{ route('tasks.create') }}" class="w-full text-sm text-gray-500 hover:text-gray-700 py-2 rounded-lg hover:bg-gray-100 transition-colors block text-center">
                        <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        タスクを追加
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
/* TODO: ハードコーディングされたCSSをTailwindのユーティリティクラスやCSSファイルに移行 */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
