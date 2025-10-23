<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'status',
        'due_date',
        'priority',
        'assignee_ids',
        'creator_id',
        'tag_ids',
        'progress',
        'comments',
        'attachment_url',
    ];

    protected $casts = [
        'assignee_ids' => 'array',
        'tag_ids' => 'array',
        'comments' => 'array',
        'due_date' => 'date',
    ];

    // ステータス定数
    const STATUS_NOT_STARTED = 0; // 未着手
    const STATUS_IN_PROGRESS = 1; // 進行中
    const STATUS_ON_HOLD = 2; // 保留
    const STATUS_COMPLETED = 3; // 完了

    // 優先度定数
    const PRIORITY_LOW = 0; // 低
    const PRIORITY_MEDIUM = 1; // 中
    const PRIORITY_HIGH = 2; // 高

    // 進捗率定数
    const PROGRESS_0 = 0;
    const PROGRESS_25 = 25;
    const PROGRESS_50 = 50;
    const PROGRESS_75 = 75;
    const PROGRESS_100 = 100;

    // リレーション
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function assignees()
    {
        return $this->belongsToMany(User::class, 'task_assignees', 'task_id', 'user_id');
    }

    // アクセサ
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            self::STATUS_NOT_STARTED => '未着手',
            self::STATUS_IN_PROGRESS => '進行中',
            self::STATUS_ON_HOLD => '保留',
            self::STATUS_COMPLETED => '完了',
            default => '不明',
        };
    }

    public function getPriorityTextAttribute()
    {
        return match($this->priority) {
            self::PRIORITY_LOW => '低',
            self::PRIORITY_MEDIUM => '中',
            self::PRIORITY_HIGH => '高',
            default => '不明',
        };
    }

    public function getFormattedDueDateAttribute()
    {
        return $this->due_date ? $this->due_date->format('Y/m/d H:i') : null;
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('Y/m/d H:i');
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return $this->updated_at->format('Y/m/d H:i');
    }

    // スコープメソッド
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeByAssignee($query, $userId)
    {
        return $query->whereJsonContains('assignee_ids', $userId);
    }

    // 静的メソッド
    public static function getActiveTasks()
    {
        return self::active()
            ->with('creator')
            ->orderBy('priority', 'desc')
            ->orderBy('due_date', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public static function getRecentTasks($limit = 5)
    {
        return self::active()
            ->with('creator')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public static function getTasksByStatus($status)
    {
        return self::active()
            ->byStatus($status)
            ->with('creator')
            ->orderBy('priority', 'desc')
            ->orderBy('due_date', 'asc')
            ->get();
    }

    public static function getTasksByAssignee($userId)
    {
        return self::active()
            ->byAssignee($userId)
            ->with('creator')
            ->orderBy('priority', 'desc')
            ->orderBy('due_date', 'asc')
            ->get();
    }

    /**
     * タスク詳細を取得
     */
    public static function getTaskDetail($id)
    {
        return self::active()
            ->with('creator')
            ->findOrFail($id);
    }

    /**
     * タスクの基本情報を取得（モーダル用）
     */
    public static function getTaskForModal($id)
    {
        return self::active()
            ->with('creator')
            ->select([
                'id', 'title', 'description', 'status', 'due_date', 
                'priority', 'assignee_ids', 'creator_id', 'progress', 
                'attachment_url', 'created_at', 'updated_at'
            ])
            ->findOrFail($id);
    }
}
