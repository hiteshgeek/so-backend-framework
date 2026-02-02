-- Add new password_hash column for secure passwords (if not exists)
ALTER TABLE auser ADD COLUMN password_hash VARCHAR(255) NULL AFTER password;
