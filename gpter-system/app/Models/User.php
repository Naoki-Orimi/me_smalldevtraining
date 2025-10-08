<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'deleted_at' => 'datetime',
    ];

    /**
     * ロール定数
     */
    public const ROLE_PRESIDENT = 'president';
    public const ROLE_MANAGER = 'manager';
    public const ROLE_MEMBER = 'member';

    /**
     * 利用可能なロール一覧
     */
    public static function getRoles(): array
    {
        return [
            self::ROLE_PRESIDENT => '社長',
            self::ROLE_MANAGER => 'マネージャー',
            self::ROLE_MEMBER => 'メンバー',
        ];
    }

    /**
     * ロール名を日本語で取得
     */
    public function getRoleNameAttribute(): string
    {
        return self::getRoles()[$this->role] ?? '不明';
    }

    /**
     * 社長かどうか
     */
    public function isPresident(): bool
    {
        return $this->role === self::ROLE_PRESIDENT;
    }

    /**
     * マネージャーかどうか
     */
    public function isManager(): bool
    {
        return $this->role === self::ROLE_MANAGER;
    }

    /**
     * メンバーかどうか
     */
    public function isMember(): bool
    {
        return $this->role === self::ROLE_MEMBER;
    }

    /**
     * 管理者権限があるかどうか（社長・マネージャー）
     */
    public function isAdmin(): bool
    {
        return in_array($this->role, [self::ROLE_PRESIDENT, self::ROLE_MANAGER]);
    }
}
