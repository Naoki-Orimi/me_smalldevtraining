<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;

class TaskStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // TODO: 認証機能実装時にログインユーザーの権限チェックを追加
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|integer|in:' . implode(',', [
                Task::STATUS_NOT_STARTED,
                Task::STATUS_IN_PROGRESS,
                Task::STATUS_ON_HOLD,
                Task::STATUS_COMPLETED,
            ]),
            'due_date' => 'nullable|date|after_or_equal:today',
            'priority' => 'required|integer|in:' . implode(',', [
                Task::PRIORITY_LOW,
                Task::PRIORITY_MEDIUM,
                Task::PRIORITY_HIGH,
            ]),
            'assignee_ids' => 'nullable|array',
            'assignee_ids.*' => 'nullable|integer|exists:users,id',
            'creator_id' => 'required|integer|exists:users,id',
            'tag_ids' => 'nullable|string|max:500',
            'progress' => 'required|integer|in:' . implode(',', [
                Task::PROGRESS_0,
                Task::PROGRESS_25,
                Task::PROGRESS_50,
                Task::PROGRESS_75,
                Task::PROGRESS_100,
            ]),
            'attachment_url' => 'nullable|url|max:500',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'タイトルは必須です。',
            'title.max' => 'タイトルは255文字以内で入力してください。',
            'description.max' => '説明は1000文字以内で入力してください。',
            'status.required' => 'ステータスは必須です。',
            'status.in' => '無効なステータスです。',
            'due_date.date' => '有効な日付を入力してください。',
            'due_date.after_or_equal' => '期日は今日以降の日付を入力してください。',
            'priority.required' => '優先度は必須です。',
            'priority.in' => '無効な優先度です。',
            'assignee_ids.array' => '担当者は配列形式で入力してください。',
            'assignee_ids.*.integer' => '担当者IDは整数で入力してください。',
            'assignee_ids.*.exists' => '選択された担当者が存在しません。',
            'tag_ids.max' => 'タグIDは500文字以内で入力してください。',
            'progress.required' => '進捗率は必須です。',
            'progress.in' => '無効な進捗率です。',
            'attachment_url.url' => '有効なURLを入力してください。',
            'attachment_url.max' => 'URLは500文字以内で入力してください。',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'title' => 'タイトル',
            'description' => '説明',
            'status' => 'ステータス',
            'due_date' => '期日',
            'priority' => '優先度',
            'assignee_ids' => '担当者',
            'creator_id' => '作成者',
            'tag_ids' => 'タグID',
            'progress' => '進捗率',
            'attachment_url' => '添付ファイルURL',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // 作成者IDを設定（TODO: 認証機能実装時にログインユーザーから取得）
        $this->merge([
            'creator_id' => 1, // 仮のユーザーID
        ]);

        // 担当者IDを配列に変換（空の場合はnullに）
        if ($this->has('assignee_ids')) {
            $assigneeIds = $this->assignee_ids;
            if (is_array($assigneeIds)) {
                $assigneeIds = array_filter($assigneeIds); // 空の値を除去
                $this->merge(['assignee_ids' => empty($assigneeIds) ? null : $assigneeIds]);
            }
        }

        // タグIDを配列に変換
        if ($this->has('tag_ids') && is_string($this->tag_ids)) {
            $tagIds = array_filter(array_map('trim', explode(',', $this->tag_ids)));
            $this->merge(['tag_ids' => implode(',', $tagIds)]);
        }
    }
}
