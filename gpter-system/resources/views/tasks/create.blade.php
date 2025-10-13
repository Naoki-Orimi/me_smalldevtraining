@extends('layouts.app')

@section('title', 'タスク作成 - タスク管理システム')

@section('content')
<div class="px-4 sm:px-0">
    <!-- セッションアラート -->
    <x-session-alerts />
    
    <!-- ヘッダー -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">タスク作成</h2>
                <p class="text-gray-600">新しいタスクを作成します。</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('tasks.index') }}" class="btn-secondary">
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    一覧に戻る
                </a>
            </div>
        </div>
    </div>

    <!-- エラーメッセージ -->
    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
            <div class="flex">
                <svg class="w-5 h-5 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- フォーム -->
    <div class="max-w-4xl mx-auto">
        <form action="{{ route('tasks.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- 基本情報 -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">基本情報</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- タイトル -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            タイトル <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                               placeholder="タスクのタイトルを入力してください"
                               required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 説明 -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            説明
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                                  placeholder="タスクの詳細な説明を入力してください">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- ステータス・優先度 -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">ステータス・優先度</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- ステータス -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            ステータス
                        </label>
                        <select id="status" 
                                name="status" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror">
                            @foreach($statusOptions as $value => $label)
                                <option value="{{ $value }}" {{ old('status', 0) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 優先度 -->
                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">
                            優先度
                        </label>
                        <select id="priority" 
                                name="priority" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('priority') border-red-500 @enderror">
                            @foreach($priorityOptions as $value => $label)
                                <option value="{{ $value }}" {{ old('priority', 1) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('priority')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 進捗率 -->
                    <div>
                        <label for="progress" class="block text-sm font-medium text-gray-700 mb-2">
                            進捗率
                        </label>
                        <select id="progress" 
                                name="progress" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('progress') border-red-500 @enderror">
                            @foreach($progressOptions as $value => $label)
                                <option value="{{ $value }}" {{ old('progress', 0) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('progress')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- 期日・担当者 -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">期日・担当者</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- 期日 -->
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">
                            期日
                        </label>
                        <input type="date" 
                               id="due_date" 
                               name="due_date" 
                               value="{{ old('due_date') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('due_date') border-red-500 @enderror">
                        @error('due_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 担当者 -->
                    <div>
                        <label for="assignee_ids" class="block text-sm font-medium text-gray-700 mb-2">
                            担当者
                        </label>
                        <select id="assignee_ids" 
                                name="assignee_ids[]" 
                                multiple
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('assignee_ids') border-red-500 @enderror">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ in_array($user->id, old('assignee_ids', [])) ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-sm text-gray-500">Ctrlキー（Mac: Cmdキー）を押しながらクリックで複数選択できます</p>
                        @error('assignee_ids')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- その他 -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">その他</h3>
                
                <div class="space-y-6">
                    <!-- 添付ファイルURL -->
                    <div>
                        <label for="attachment_url" class="block text-sm font-medium text-gray-700 mb-2">
                            添付ファイルURL
                        </label>
                        <input type="url" 
                               id="attachment_url" 
                               name="attachment_url" 
                               value="{{ old('attachment_url') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('attachment_url') border-red-500 @enderror"
                               placeholder="https://example.com/file.pdf">
                        <p class="mt-1 text-sm text-gray-500">ファイルのURLを入力してください</p>
                        @error('attachment_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- タグID（将来の拡張用） -->
                    <div>
                        <label for="tag_ids" class="block text-sm font-medium text-gray-700 mb-2">
                            タグID
                        </label>
                        <input type="text" 
                               id="tag_ids" 
                               name="tag_ids" 
                               value="{{ old('tag_ids') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tag_ids') border-red-500 @enderror"
                               placeholder="1,2,3 (カンマ区切りで入力)">
                        <p class="mt-1 text-sm text-gray-500">タグIDをカンマ区切りで入力してください（将来の機能）</p>
                        @error('tag_ids')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- ボタン -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('tasks.index') }}" class="btn-secondary">
                    キャンセル
                </a>
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    タスクを作成
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
