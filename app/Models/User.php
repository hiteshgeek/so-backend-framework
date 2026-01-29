<?php

namespace App\Models;

use Core\Model\Model;

/**
 * User Model
 */
class User extends Model
{
    protected static string $table = 'users';

    protected array $fillable = [
        'name',
        'email',
        'password',
        'created_at',
        'updated_at',
    ];

    protected array $guarded = ['id'];

    protected function setPasswordAttribute(string $value): void
    {
        $this->attributes['password'] = password_hash($value, PASSWORD_ARGON2ID);
    }

    protected function getNameAttribute(?string $value): string
    {
        return $value ? ucwords($value) : '';
    }

    public static function findByEmail(string $email): ?static
    {
        $result = static::query()
            ->where('email', '=', $email)
            ->first();

        return $result ? new static($result) : null;
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->attributes['password']);
    }
}
