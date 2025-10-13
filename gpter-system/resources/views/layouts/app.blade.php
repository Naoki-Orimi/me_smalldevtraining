<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'タスク管理システム')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Vite CSS -->
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- ヘッダー -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- ロゴ -->
                <div class="flex items-center">
                    <h1 class="text-xl font-bold text-gray-900">タスク管理システム</h1>
                </div>
                
                <!-- ナビゲーション -->
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-900 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">ダッシュボード</a>
                    <a href="#" class="text-gray-500 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">タスク一覧</a>
                    <a href="#" class="text-gray-500 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">プロジェクト</a>
                    <a href="#" class="text-gray-500 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">チーム</a>
                </nav>
                
                <!-- ユーザーメニュー -->
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center">
                                <span class="text-white text-sm font-medium">U</span>
                            </div>
                            <span class="ml-2 text-gray-700">ユーザー</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- メインコンテンツ -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    <!-- フッター -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm text-gray-500">
                © 2025 株式会社 GPTER. All rights reserved.
            </p>
        </div>
    </footer>

    <!-- Vite JavaScript -->
    @vite(['resources/js/app.js'])
</body>
</html>
