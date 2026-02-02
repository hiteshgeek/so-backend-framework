<?php

namespace App\Models;

use Core\Model\Model;
use Core\ActivityLog\LogsActivity;
use Core\Notifications\Notifiable;
use Core\Model\Traits\HasStatusField;
use Core\Security\LegacyPasswordHasher;
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
        'password_hash',  // New secure password field
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
     *
     * During migration period, stores password in both formats:
     * - password: Legacy format (sha1) for old framework compatibility
     * - password_hash: Modern format (argon2id) for new framework
     *
     * After migration is complete, remove legacy hash storage.
     */
    protected function setPasswordAttribute(?string $value): void
    {
        // Handle null/empty password (e.g., when loading from DB with NULL password)
        if ($value === null || $value === '') {
            $this->attributes['password'] = $value;
            return;
        }

        // Don't re-hash if already hashed
        if (LegacyPasswordHasher::isModernHash($value)) {
            $this->attributes['password_hash'] = $value;
            return;
        }

        if (LegacyPasswordHasher::isLegacyHash($value)) {
            $this->attributes['password'] = $value;
            return;
        }

        // Plain text password - hash in BOTH formats for compatibility
        // Legacy format for old framework (temporary, during migration)
        $this->attributes['password'] = LegacyPasswordHasher::hash($value);

        // Modern secure format (permanent)
        $this->attributes['password_hash'] = password_hash($value, PASSWORD_ARGON2ID);
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
     * Verify password with automatic migration
     *
     * Verification priority:
     * 1. Try modern hash (password_hash column) if present
     * 2. Fall back to legacy hash (password column)
     * 3. On successful legacy verification, upgrade to modern hash
     *
     * @param string $password Plain text password
     * @return bool True if password is valid
     */
    public function verifyPassword(string $password): bool
    {
        $modernHash = $this->attributes['password_hash'] ?? null;
        $legacyHash = $this->attributes['password'] ?? null;

        // Priority 1: Try modern hash if available
        if ($modernHash && LegacyPasswordHasher::isModernHash($modernHash)) {
            if (password_verify($password, $modernHash)) {
                // Check if password needs rehashing (algorithm upgrade)
                if (password_needs_rehash($modernHash, PASSWORD_ARGON2ID)) {
                    $this->upgradePassword($password);
                }
                return true;
            }
            // Modern hash exists but doesn't match - fail
            // Don't fall back if user already has modern password
            return false;
        }

        // Priority 2: Try legacy hash
        if ($legacyHash && LegacyPasswordHasher::isLegacyHash($legacyHash)) {
            if (LegacyPasswordHasher::verify($password, $legacyHash)) {
                // SUCCESS with legacy password - upgrade to modern hash
                $this->upgradePassword($password);
                return true;
            }
        }

        return false;
    }

    /**
     * Upgrade password to modern hash format
     *
     * Called automatically when user logs in with legacy password.
     * Stores the new secure hash without changing the legacy hash
     * (so old framework continues to work).
     *
     * @param string $plainPassword The plain text password
     */
    protected function upgradePassword(string $plainPassword): void
    {
        // Store modern hash directly (bypass mutator to avoid re-hashing legacy)
        $this->attributes['password_hash'] = password_hash($plainPassword, PASSWORD_ARGON2ID);

        // Save only the password_hash field
        $db = app('db');
        $db->table(static::$table)
            ->where(static::$primaryKey, '=', $this->attributes[static::$primaryKey])
            ->update(['password_hash' => $this->attributes['password_hash']]);

        error_log("Password upgraded to modern hash for user: " . ($this->attributes['email'] ?? 'unknown'));
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
