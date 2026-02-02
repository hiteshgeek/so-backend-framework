<?php

namespace App\Models;

use Core\Model\Model;
use Core\ActivityLog\LogsActivity;
use Core\Notifications\Notifiable;
use Core\Model\Traits\HasStatusField;
use App\Constants\DatabaseTables;

/**
 * User Model - Adapted for existing auser table
 *
 * This model works with the existing 'auser' table structure
 * from your staging/production database.
 */
class User extends Model
{
    use LogsActivity;
    use Notifiable;
    use HasStatusField;

    // ============================================
    // TABLE CONFIGURATION
    // ============================================

    /**
     * Use existing auser table
     */
    protected static string $table = DatabaseTables::AUSER;

    /**
     * Use main application database (not essentials)
     */
    protected static string $connection = 'db';

    /**
     * Primary key column name
     */
    protected static string $primaryKey = 'uid';

    // ============================================
    // TIMESTAMP CONFIGURATION
    // ============================================

    /**
     * Enable timestamps (auser table has created_ts/updated_ts)
     */
    protected bool $timestamps = true;

    /**
     * Enable userstamps (auser table has created_uid/updated_uid)
     */
    protected bool $userstamps = true;

    /**
     * Map framework's CREATED_AT to actual column name
     * Access via: $user->getCreatedAt() or $user->created_ts
     */
    const CREATED_AT = 'created_ts';

    /**
     * Map framework's UPDATED_AT to actual column name
     * Access via: $user->getUpdatedAt() or $user->updated_ts
     */
    const UPDATED_AT = 'updated_ts';

    /**
     * Map framework's CREATED_BY to actual column name
     * Access via: $user->getCreatedBy() or $user->created_uid
     */
    const CREATED_BY = 'created_uid';

    /**
     * Map framework's UPDATED_BY to actual column name
     * Access via: $user->getUpdatedBy() or $user->updated_uid
     */
    const UPDATED_BY = 'updated_uid';

    // ============================================
    // MASS ASSIGNMENT PROTECTION
    // ============================================

    protected array $fillable = [
        'uid',  // Primary key - needed for loading from database
        'name',
        'email',
        'mobile',
        'password',
        'ustatusid',
        'is_admin',
        'non_login',
        'is_super',
        'empid',
        'report_to',
        'description',
        'designation',
        'email_signature',
        'address_line_1',
        'address_line_2',
        'genderid',
        'photo',
        'date_of_birth',
        'date_of_joining',
        'date_of_leaving',
        'company_id',
        // Email/mailbox configuration
        'mail_box_hostname',
        'mail_box_port',
        'mail_box_service',
        'mail_box_username',
        'mail_box_password',
        // Additional required fields
        'coverlid',
        'zip_code',
        'licid',
        'hard_limit',
        'soft_limit',
        'is_multipler',
        // Localization fields
        'locale',
        'timezone',
    ];

    protected array $guarded = [
        // uid removed - it's the primary key and needs to be fillable when loading from DB
        'created_ts',
        'updated_ts',
        'created_uid',
        'updated_uid',
    ];

    // ============================================
    // ACTIVITY LOGGING CONFIGURATION
    // ============================================

    protected static bool $logsActivity = false;  // Disabled: activity_log is in essentials DB
    protected static array $logAttributes = ['name', 'email', 'mobile']; // Don't log password
    protected static bool $logOnlyDirty = true;
    protected static string $logName = 'user';

    // ============================================
    // STATUS FIELD CONFIGURATION (HasStatusField trait)
    // ============================================

    /**
     * Constructor - Set status field configuration
     */
    public function __construct(array $attributes = [])
    {
        // Configure status field before calling parent constructor
        $this->statusField = 'ustatusid';
        $this->activeStatusValues = [1];
        $this->inactiveStatusValues = [2, 3];
        $this->autoFilterInactive = false;

        parent::__construct($attributes);
    }

    // ============================================
    // ATTRIBUTE ACCESSORS & MUTATORS
    // ============================================

    /**
     * Hash password when setting
     */
    protected function setPasswordAttribute(string $value): void
    {
        // Only hash if not already hashed (check for bcrypt or argon2 prefix)
        if (str_starts_with($value, '$2y$') || str_starts_with($value, '$argon2')) {
            $this->attributes['password'] = $value;
        } else {
            $this->attributes['password'] = password_hash($value, PASSWORD_ARGON2ID);
        }
    }

    /**
     * Capitalize name when getting
     */
    protected function getNameAttribute(?string $value): string
    {
        return $value ? ucwords($value) : '';
    }

    // ============================================
    // QUERY METHODS
    // ============================================

    /**
     * Find user by email
     */
    public static function findByEmail(string $email): ?static
    {
        $result = static::query()
            ->where('email', '=', $email)
            ->first();

        error_log("User::findByEmail - Result: " . print_r($result, true));

        if ($result) {
            $instance = new static($result);
            $instance->exists = true;
            $instance->original = $result;
            error_log("User::findByEmail - Instance UID: " . var_export($instance->uid, true) . ", ID: " . var_export($instance->id, true));
            return $instance;
        }

        return null;
    }

    /**
     * Find user by mobile
     */
    public static function findByMobile(string $mobile): ?static
    {
        $result = static::query()
            ->where('mobile', '=', $mobile)
            ->first();

        if ($result) {
            $instance = new static($result);
            $instance->exists = true;
            $instance->original = $result;
            return $instance;
        }

        return null;
    }

    /**
     * Find user by ID (uid)
     */
    public static function find(int $uid): ?static
    {
        $result = static::query()
            ->where('uid', '=', $uid)
            ->first();

        if ($result) {
            $instance = new static($result);
            $instance->exists = true;
            $instance->original = $result;
            return $instance;
        }

        return null;
    }

    // ============================================
    // AUTHENTICATION METHODS
    // ============================================

    /**
     * Verify password
     */
    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->attributes['password']);
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return (bool) ($this->attributes['is_admin'] ?? false);
    }

    /**
     * Check if user is super admin
     */
    public function isSuperAdmin(): bool
    {
        return (bool) ($this->attributes['is_super'] ?? false);
    }

    /**
     * Check if user login is disabled
     */
    public function isLoginDisabled(): bool
    {
        return (bool) ($this->attributes['non_login'] ?? false);
    }

    /**
     * Check if user account is locked
     */
    public function isLocked(): bool
    {
        return (bool) ($this->attributes['locked'] ?? false);
    }

    // ============================================
    // RELATIONSHIPS & ADDITIONAL METHODS
    // ============================================

    /**
     * Get user's active sessions
     */
    public function getSessions(): array
    {
        return app('db')
            ->table(DatabaseTables::AUSER_SESSION)
            ->where('uid', $this->uid)
            ->get();
    }

    /**
     * Get user ID (primary key accessor)
     */
    public function __get(string $key): mixed
    {
        // Map 'id' to 'uid' for compatibility with framework
        if ($key === 'id') {
            return $this->attributes['uid'] ?? null;
        }

        return parent::__get($key);
    }

    // ============================================
    // LOCALIZATION METHODS
    // ============================================

    /**
     * Get user's preferred locale
     *
     * @return string Locale code (e.g., 'en', 'fr', 'de')
     */
    public function getLocale(): string
    {
        return $this->attributes['locale'] ?? config('app.locale', 'en');
    }

    /**
     * Set user's preferred locale
     *
     * @param string $locale Locale code
     * @return bool True if saved successfully
     */
    public function setLocale(string $locale): bool
    {
        $this->attributes['locale'] = $locale;
        return $this->save();
    }

    /**
     * Get user's preferred timezone
     *
     * @return string Timezone identifier (e.g., 'UTC', 'America/New_York')
     */
    public function getTimezone(): string
    {
        return $this->attributes['timezone'] ?? config('app.timezone', 'UTC');
    }

    /**
     * Set user's preferred timezone
     *
     * @param string $timezone Timezone identifier
     * @return bool True if saved successfully
     */
    public function setTimezone(string $timezone): bool
    {
        $this->attributes['timezone'] = $timezone;
        return $this->save();
    }
}
