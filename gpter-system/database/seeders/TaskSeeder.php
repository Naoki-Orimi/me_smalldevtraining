<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ユーザーを取得（テスト用）
        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->command->warn('ユーザーが存在しません。先にUserSeederを実行してください。');
            return;
        }

        $sampleTasks = [
            [
                'title' => 'プロジェクト企画書の作成',
                'description' => '新規プロジェクトの企画書を作成し、関係者に共有する',
                'status' => Task::STATUS_IN_PROGRESS,
                'due_date' => now()->addDays(7),
                'priority' => Task::PRIORITY_HIGH,
                'assignee_ids' => [$users->first()->id],
                'creator_id' => $users->first()->id,
                'tag_ids' => [1, 2],
                'progress' => Task::PROGRESS_50,
                'comments' => [
                    [
                        'user_id' => $users->first()->id,
                        'comment' => '企画書の骨子を作成しました',
                        'created_at' => now()->subDays(2)->toDateTimeString(),
                    ],
                    [
                        'user_id' => $users->first()->id,
                        'comment' => '予算部分を追加しました',
                        'created_at' => now()->subDays(1)->toDateTimeString(),
                    ],
                ],
                'attachment_url' => 'https://example.com/project-proposal.pdf',
            ],
            [
                'title' => 'データベース設計の見直し',
                'description' => '既存のデータベース設計をレビューし、パフォーマンス改善案を検討する',
                'status' => Task::STATUS_NOT_STARTED,
                'due_date' => now()->addDays(14),
                'priority' => Task::PRIORITY_MEDIUM,
                'assignee_ids' => [$users->first()->id, $users->skip(1)->first()->id ?? $users->first()->id],
                'creator_id' => $users->first()->id,
                'tag_ids' => [3],
                'progress' => Task::PROGRESS_0,
                'comments' => [],
                'attachment_url' => null,
            ],
            [
                'title' => 'ユーザーインターフェースの改善',
                'description' => 'ユーザビリティテストの結果を基にUIを改善する',
                'status' => Task::STATUS_ON_HOLD,
                'due_date' => now()->addDays(21),
                'priority' => Task::PRIORITY_LOW,
                'assignee_ids' => [$users->first()->id],
                'creator_id' => $users->first()->id,
                'tag_ids' => [4, 5],
                'progress' => Task::PROGRESS_25,
                'comments' => [
                    [
                        'user_id' => $users->first()->id,
                        'comment' => 'ユーザビリティテストの結果を分析中',
                        'created_at' => now()->subDays(3)->toDateTimeString(),
                    ],
                ],
                'attachment_url' => null,
            ],
            [
                'title' => 'セキュリティ監査の実施',
                'description' => 'システム全体のセキュリティ監査を実施し、脆弱性を特定する',
                'status' => Task::STATUS_COMPLETED,
                'due_date' => now()->subDays(5),
                'priority' => Task::PRIORITY_HIGH,
                'assignee_ids' => [$users->first()->id],
                'creator_id' => $users->first()->id,
                'tag_ids' => [6],
                'progress' => Task::PROGRESS_100,
                'comments' => [
                    [
                        'user_id' => $users->first()->id,
                        'comment' => '監査を開始しました',
                        'created_at' => now()->subDays(10)->toDateTimeString(),
                    ],
                    [
                        'user_id' => $users->first()->id,
                        'comment' => '脆弱性を3件発見し、修正完了',
                        'created_at' => now()->subDays(5)->toDateTimeString(),
                    ],
                ],
                'attachment_url' => 'https://example.com/security-audit-report.pdf',
            ],
            [
                'title' => 'API仕様書の更新',
                'description' => '新機能追加に伴いAPI仕様書を更新する',
                'status' => Task::STATUS_IN_PROGRESS,
                'due_date' => now()->addDays(3),
                'priority' => Task::PRIORITY_MEDIUM,
                'assignee_ids' => [$users->first()->id],
                'creator_id' => $users->first()->id,
                'tag_ids' => [7, 8],
                'progress' => Task::PROGRESS_75,
                'comments' => [
                    [
                        'user_id' => $users->first()->id,
                        'comment' => '新エンドポイントの仕様を追加',
                        'created_at' => now()->subDays(1)->toDateTimeString(),
                    ],
                ],
                'attachment_url' => null,
            ],
        ];

        foreach ($sampleTasks as $taskData) {
            Task::create($taskData);
        }

        $this->command->info('タスクのサンプルデータを作成しました。');
    }
}
