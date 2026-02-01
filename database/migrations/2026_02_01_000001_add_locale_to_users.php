<?php

use Core\Database\Migration;

/**
 * Add Locale and Timezone Columns to Users Table
 *
 * Migration to add internationalization support for users.
 * Adds locale and timezone preferences to the auser table.
 */
return new class extends Migration
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        $sql = "
            ALTER TABLE auser
            ADD COLUMN locale VARCHAR(10) DEFAULT 'en' NOT NULL AFTER email,
            ADD COLUMN timezone VARCHAR(50) DEFAULT 'UTC' NOT NULL AFTER locale,
            ADD INDEX idx_locale (locale)
        ";

        $this->execute($sql);
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        $sql = "
            ALTER TABLE auser
            DROP INDEX idx_locale,
            DROP COLUMN timezone,
            DROP COLUMN locale
        ";

        $this->execute($sql);
    }
};
