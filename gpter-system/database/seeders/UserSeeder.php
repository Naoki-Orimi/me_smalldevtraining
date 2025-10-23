<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 既存のユーザーをクリア（開発環境用）
        // User::truncate(); // 外部キー制約があるためコメントアウト

        // 管理者ユーザー（社長）
        User::create([
            'name' => '管理太郎',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_PRESIDENT,
            'email_verified_at' => now(),
        ]);

        // マネージャーユーザー
        User::create([
            'name' => 'マネ一朗',
            'email' => 'manager1@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_MANAGER,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'マネ二郎',
            'email' => 'manager2@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_MANAGER,
            'email_verified_at' => now(),
        ]);

        // メンバーユーザー
        User::create([
            'name' => 'メンバ三郎',
            'email' => 'member1@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_MEMBER,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'メンバ四郎',
            'email' => 'member2@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_MEMBER,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'メンバ五郎',
            'email' => 'member3@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_MEMBER,
            'email_verified_at' => now(),
        ]);

        $this->command->info('ユーザーシーダーが完了しました。');
        $this->command->info('管理者: admin@example.com / password');
        $this->command->info('マネージャー: manager1@example.com, manager2@example.com / password');
        $this->command->info('メンバー: member1@example.com, member2@example.com, member3@example.com / password');
    }
}
