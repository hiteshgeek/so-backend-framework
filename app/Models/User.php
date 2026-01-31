<?php

namespace App\Models;

use Core\Model\Model;
use Core\ActivityLog\LogsActivity;
use Core\Notifications\Notifiable;

/**
 * User Model
 */
class User extends Model
{
    use LogsActivity;
    use Notifiable;

    protected static string $table = 'users';

    protected array $fillable = [
        'name',
        'email',
        'password',
    ];

    protected array $guarded = [
        'id',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    /**
     * Activity logging configuration
     */
    protected static bool $logsActivity = true;
    protected static array $logAttributes = ['name', 'email']; // Don't log password
    protected static bool $logOnlyDirty = true;
    protected static string $logName = 'user';

    protected function setPasswordAttribute(string $value): void
    {
        // Only hash if not already hashed (check for bcrypt or argon2 prefix)
        if (str_starts_with($value, '$2y$') || str_starts_with($value, '$argon2')) {
            $this->attributes['password'] = $value;
        } else {
            $this->attributes['password'] = password_hash($value, PASSWORD_ARGON2ID);
        }
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

        if ($result) {
            $instance = new static($result);
            $instance->exists = true;
            $instance->original = $result;
            return $instance;
        }

        return null;
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->attributes['password']);
    }
}
