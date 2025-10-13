@extends('layouts.app')

@section('title', 'ダッシュボード - タスク管理システム')

@section('content')
<div class="px-4 sm:px-0">
    <!-- ウェルカムセクション -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">ダッシュボード</h2>
        <p class="text-gray-600">タスクの進捗状況と概要を確認できます。</p>
    </div>

    <!-- 統計カード -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="card">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">総タスク数</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $tasks->count() }}</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">完了済み</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $taskCounts['completed'] }}</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">進行中</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $taskCounts['in_progress'] }}</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">未着手</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $taskCounts['not_started'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- メインコンテンツエリア -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- 最近のタスク -->
        <div class="lg:col-span-2">
            <div class="card">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">最近のタスク</h3>
                    <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">すべて表示</a>
                </div>
                
                @if($tasks->count() > 0)
                    <!-- タスク一覧 -->
                    <div class="space-y-4">
                        @foreach($tasks as $task)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-2">
                                            <h4 class="text-sm font-medium text-gray-900">{{ $task->title }}</h4>
                                            <!-- ステータスバッジ -->
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($task->status == 0) bg-gray-100 text-gray-800
                                                @elseif($task->status == 1) bg-blue-100 text-blue-800
                                                @elseif($task->status == 2) bg-yellow-100 text-yellow-800
                                                @else bg-green-100 text-green-800
                                                @endif">
                                                {{ $task->status_text }}
                                            </span>
                                            <!-- 優先度バッジ -->
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($task->priority == 0) bg-gray-100 text-gray-800
                                                @elseif($task->priority == 1) bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ $task->priority_text }}
                                            </span>
                                        </div>
                                        
                                        @if($task->description)
                                            <p class="text-sm text-gray-600 mb-2">{{ Str::limit($task->description, 100) }}</p>
                                        @endif
                                        
                                        <div class="flex items-center space-x-4 text-xs text-gray-500">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                                {{ $task->creator->name }}
                                            </div>
                                            
                                            @if($task->due_date)
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    {{ $task->due_date->format('Y/m/d') }}
                                                </div>
                                            @endif
                                            
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                                </svg>
                                                {{ $task->progress }}%
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center space-x-2 ml-4">
                                        @if($task->attachment_url)
                                            <a href="{{ $task->attachment_url }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                                </svg>
                                            </a>
                                        @endif
                                        
                                        <button class="text-gray-400 hover:text-gray-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- 進捗バー -->
                                <div class="mt-3">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ $task->progress }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- 空の状態 -->
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">タスクがありません</h3>
                        <p class="mt-1 text-sm text-gray-500">新しいタスクを作成して始めましょう。</p>
                        <div class="mt-6">
                            <button class="btn-primary">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                タスクを作成
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- サイドバー -->
        <div class="space-y-6">
            <!-- クイックアクション -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">クイックアクション</h3>
                <div class="space-y-3">
                    <button class="w-full btn-primary text-left">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        新しいタスク
                    </button>
                    <button class="w-full btn-secondary text-left">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        チーム管理
                    </button>
                    <button class="w-full btn-secondary text-left">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        レポート
                    </button>
                </div>
            </div>

            <!-- 期限が近いタスク -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">期限が近いタスク</h3>
                <div class="text-center py-8">
                    <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">期限が近いタスクはありません</p>
                </div>
            </div>

            <!-- システム情報 -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">システム情報</h3>
                <div class="space-y-2 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span>バージョン:</span>
                        <span class="font-medium">v1.0.0</span>
                    </div>
                    <div class="flex justify-between">
                        <span>最終更新:</span>
                        <span class="font-medium">{{ date('Y-m-d') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>ステータス:</span>
                        <span class="text-green-600 font-medium">稼働中</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
