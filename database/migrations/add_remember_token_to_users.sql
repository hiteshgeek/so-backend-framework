-- Add remember_token column to users table for "Remember Me" functionality

ALTER TABLE users
ADD COLUMN remember_token VARCHAR(100) NULL AFTER password,
ADD INDEX idx_remember_token (remember_token);
