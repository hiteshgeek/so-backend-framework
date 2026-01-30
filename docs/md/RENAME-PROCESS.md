# Framework Rename Process - Step by Step

This document explains the **exact same process** that [rename-framework.sh](rename-framework.sh) automates.

You can either:
- **Run the script** (30 seconds): `./rename-framework.sh "Name" "db" "vendor/pkg"`
- **Follow this guide manually** (10 minutes): Step-by-step instructions below

---

## [List] What This Process Does

This rename process changes your framework identity from:

```
Current:  SO Framework  →  Your Framework Name
Database: so-framework  →  your-database
Package:  so/framework  →  vendor/package
```

**Files that will be modified:**
1. `.env` - Runtime configuration
2. `.env.example` - Template for new installs
3. `composer.json` - Package identity
4. `database/migrations/setup.sql` - Auto-regenerated with new DB name
5. `README.md` - Documentation (optional)
6. `SETUP.md` - Documentation (optional)
7. `CONFIGURATION.md` - Documentation (optional)
8. `QUICK-START.md` - Documentation (optional)

---

## [*] Prerequisites

Before starting:

- [ ] Decide on your new framework name (e.g., "Acme Framework")
- [ ] Decide on database name (e.g., "acme-framework")
- [ ] Decide on package name (e.g., "acme/framework")
- [ ] **Backup your files** (recommended)

```bash
# Create backup
mkdir -p backups
cp .env backups/.env.backup
cp composer.json backups/composer.json.backup
cp database/migrations/setup.sql backups/setup.sql.backup
```

---

## [Note] Step-by-Step Manual Process

### Step 1: Update .env File

**File:** `.env`

**What to change:**

```bash
# OLD:
APP_NAME="SO Framework"
DB_DATABASE=so-framework

# NEW:
APP_NAME="Your Framework Name"
DB_DATABASE=your-database-name
```

**How to do it:**

```bash
# Open file
nano .env

# Find line 2 and change:
APP_NAME="Your Framework Name"

# Find line 12 and change:
DB_DATABASE=your-database-name

# Save and exit (Ctrl+X, then Y, then Enter)
```

**Or use sed:**

```bash
sed -i 's/APP_NAME="SO Framework"/APP_NAME="Your Framework Name"/' .env
sed -i 's/DB_DATABASE=so-framework/DB_DATABASE=your-database-name/' .env
```

---

### Step 2: Update .env.example File

**File:** `.env.example`

**What to change:** Same as Step 1 (lines 2 and 12)

```bash
# Open file
nano .env.example

# Change line 2:
APP_NAME="Your Framework Name"

# Change line 12:
DB_DATABASE=your-database-name

# Save and exit
```

**Or use sed:**

```bash
sed -i 's/APP_NAME="SO Framework"/APP_NAME="Your Framework Name"/' .env.example
sed -i 's/DB_DATABASE=so-framework/DB_DATABASE=your-database-name/' .env.example
```

---

### Step 3: Update composer.json File

**File:** `composer.json`

**What to change:**

```json
{
    "name": "so/framework",              ← Change this
    "description": "Production-ready...", ← Optional: update description
    ...
}
```

**How to do it:**

```bash
# Open file
nano composer.json

# Find line 2 and change:
"name": "vendor/your-package",

# Optional - line 3, update description:
"description": "Your custom description",

# Save and exit
```

**Or use sed:**

```bash
sed -i 's/"name": "so\/framework"/"name": "vendor\/your-package"/' composer.json
```

---

### Step 4: Regenerate Database Setup SQL

**Command to run:**

```bash
php database/migrations/generate-setup.php
```

**What this does:**
- Reads `APP_NAME` and `DB_DATABASE` from your updated `.env`
- Generates a new `setup.sql` file with correct database name
- Includes your framework name in SQL comments

**Output you should see:**

```
[x] Generated setup.sql with database: your-database-name
📁 File: /path/to/database/migrations/setup.sql

To import:
  mysql -u root -p < /path/to/database/migrations/setup.sql
```

**Verify the generated file:**

```bash
# Check the first few lines
head -n 10 database/migrations/setup.sql
```

You should see:

```sql
-- Auto-generated setup SQL for: Your Framework Name
-- Database: your-database-name
-- Generated: 2026-01-29 12:00:00

-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS `your-database-name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use the database
USE `your-database-name`;
```

---

### Step 5: Update Composer Autoloader

**Command to run:**

```bash
composer dump-autoload
```

**What this does:**
- Updates the autoloader with your new package name
- Optimizes class loading

**Output you should see:**

```
Generating optimized autoload files
Generated optimized autoload files containing X classes
```

---

### Step 6: Update Documentation Files (Optional)

This step is **optional** but recommended for consistency.

#### Update README.md

```bash
# Open file
nano README.md

# Find and replace:
# "SO Framework" → "Your Framework Name"
# "so-framework" → "your-database-name"

# Save and exit
```

**Or use sed:**

```bash
sed -i 's/SO Framework/Your Framework Name/g' README.md
sed -i 's/so-framework/your-database-name/g' README.md
```

#### Update SETUP.md

```bash
sed -i 's/SO Framework/Your Framework Name/g' SETUP.md
sed -i 's/so-framework/your-database-name/g' SETUP.md
```

#### Update CONFIGURATION.md

```bash
sed -i 's/SO Framework/Your Framework Name/g' CONFIGURATION.md
sed -i 's/so-framework/your-database-name/g' CONFIGURATION.md
```

#### Update QUICK-START.md

```bash
sed -i 's/SO Framework/Your Framework Name/g' QUICK-START.md
sed -i 's/so-framework/your-database-name/g' QUICK-START.md
```

**Batch update all markdown files:**

```bash
# Update all .md files at once
find . -name "*.md" -type f -exec sed -i 's/SO Framework/Your Framework Name/g' {} +
find . -name "*.md" -type f -exec sed -i 's/so-framework/your-database-name/g' {} +
```

---

### Step 7: Import Database

**Command to run:**

```bash
mysql -u root -p < database/migrations/setup.sql
```

**What this does:**
- Creates your database with the new name
- Creates all tables
- Inserts sample data

**Verify database was created:**

```bash
mysql -u root -p -e "SHOW DATABASES LIKE 'your-database-name';"
```

**Verify tables were created:**

```bash
mysql -u root -p your-database-name -e "SHOW TABLES;"
```

Expected output:

```
+---------------------------+
| Tables_in_your-database   |
+---------------------------+
| posts                     |
| users                     |
+---------------------------+
```

---

## [x] Verification Steps

After completing all steps, verify everything works:

### 1. Check Environment Variables

```bash
php -r "
require 'vendor/autoload.php';
use Core\Support\Env;
Env::load('.env');
echo 'Framework Name: ' . env('APP_NAME') . PHP_EOL;
echo 'Database Name: ' . env('DB_DATABASE') . PHP_EOL;
"
```

**Expected output:**

```
Framework Name: Your Framework Name
Database Name: your-database-name
```

### 2. Check Generated SQL

```bash
head -5 database/migrations/setup.sql
```

**Expected output:**

```sql
-- Auto-generated setup SQL for: Your Framework Name
-- Database: your-database-name
```

### 3. Check Composer

```bash
composer validate
```

**Expected output:**

```
./composer.json is valid
```

### 4. Test Homepage

```bash
curl http://localhost:8000 | grep -i "title"
```

**Expected:** Should show your new framework name

### 5. Test API

```bash
curl http://localhost:8000/api/test
```

**Expected:**

```json
{
  "success": true,
  "message": "Success",
  "data": {
    "message": "Framework is working!",
    "version": "1.0.0"
  }
}
```

### 6. Test Database Connection

```bash
curl http://localhost:8000/api/v1/users
```

**Expected:** Should return users from your database

---

## [Chart] Summary Checklist

After completing the process, you should have:

- [x] **Step 1:** Updated `.env` with new name and database
- [x] **Step 2:** Updated `.env.example` with same changes
- [x] **Step 3:** Updated `composer.json` with new package name
- [x] **Step 4:** Regenerated `setup.sql` with correct database name
- [x] **Step 5:** Updated composer autoloader
- [x] **Step 6:** Updated documentation files (optional)
- [x] **Step 7:** Imported database with new name
- [x] **Verification:** All tests passed

---

## [~] What Happens Automatically vs Manually

### Automatic (No Code Changes Needed)

When you update `.env`, these work automatically:

[x] **Views** - Use `config('app.name')`, displays new name automatically
[x] **Database Connections** - Read from config, connect to new database
[x] **API Responses** - Any code using `config()` updates automatically
[x] **Error Pages** - Framework name in error messages
[x] **Logs** - Application name in log entries

### Manual Updates Required

These require file editing or regeneration:

[Note] **setup.sql** - Must regenerate with Step 4
[Note] **composer.json** - Must manually edit package name
[Note] **Documentation** - Optional, for consistency

---

## [?] Troubleshooting

### Issue: "config('app.name') returns old name"

**Solution:**

```bash
# Clear any caches
rm -rf storage/cache/*
rm -rf bootstrap/cache/*

# Verify .env was updated
cat .env | grep APP_NAME
```

### Issue: "Database connection failed"

**Solution:**

```bash
# Verify database exists
mysql -u root -p -e "SHOW DATABASES LIKE 'your-database-name';"

# If not, reimport
mysql -u root -p < database/migrations/setup.sql

# Verify .env has correct database name
cat .env | grep DB_DATABASE
```

### Issue: "Composer errors"

**Solution:**

```bash
# Validate syntax
composer validate

# If invalid, check composer.json
cat composer.json | head -10

# Reinstall if needed
rm -rf vendor composer.lock
composer install
```

### Issue: "Changes not showing on website"

**Solution:**

```bash
# Restart PHP server if using built-in server
pkill -f "php -S"
php -S localhost:8000 -t public &

# Clear browser cache
# Or test with curl
curl -s http://localhost:8000 | grep title
```

---

## [List] Quick Reference Command List

**Copy and paste these commands (replace values):**

```bash
# Step 1 & 2: Update .env files
sed -i 's/APP_NAME="SO Framework"/APP_NAME="Your Framework Name"/' .env
sed -i 's/DB_DATABASE=so-framework/DB_DATABASE=your-database/' .env
sed -i 's/APP_NAME="SO Framework"/APP_NAME="Your Framework Name"/' .env.example
sed -i 's/DB_DATABASE=so-framework/DB_DATABASE=your-database/' .env.example

# Step 3: Update composer.json
sed -i 's/"name": "so\/framework"/"name": "vendor\/package"/' composer.json

# Step 4: Regenerate SQL
php database/migrations/generate-setup.php

# Step 5: Update autoloader
composer dump-autoload

# Step 6: Update docs (optional)
find . -name "*.md" -type f -exec sed -i 's/SO Framework/Your Framework Name/g' {} +
find . -name "*.md" -type f -exec sed -i 's/so-framework/your-database/g' {} +

# Step 7: Import database
mysql -u root -p < database/migrations/setup.sql

# Verify
php -r "require 'vendor/autoload.php'; use Core\Support\Env; Env::load('.env'); echo 'Name: ' . env('APP_NAME') . PHP_EOL; echo 'DB: ' . env('DB_DATABASE') . PHP_EOL;"
```

---

## [!] Complete!

Your framework has been renamed! The new identity is now:

- **Display Name:** Your Framework Name
- **Database:** your-database-name
- **Package:** vendor/package

**What changed:**
- [x] All configuration files
- [x] Database setup SQL
- [x] Package identity
- [x] Documentation (if you did Step 6)

**What works automatically:**
- [x] Views show new name
- [x] Database connections use new name
- [x] Config references resolve correctly

---

## [->] Alternative: Use the Automated Script

Instead of following this manual process, you can use the automated script:

```bash
./rename-framework.sh "Your Framework Name" "your-database" "vendor/package"
```

The script does **exactly the same steps** as this document, but automatically!

It also includes:
- [x] Automatic backups
- [x] Colored output
- [x] Confirmation prompts
- [x] Error handling
- [x] Progress indicators

---

## [Docs] Related Documentation

- **[Framework Branding](/docs/branding)** - Complete file reference
- **[rename-framework.sh](rename-framework.sh)** - Automated script
- **[Configuration](/docs/configuration)** - Configuration system guide
- **[Quick Start](/docs/quick-start)** - Quick reference

---

**Questions?** See [Framework Branding](/docs/branding) for detailed information about each file.
