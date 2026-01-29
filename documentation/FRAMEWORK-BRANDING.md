# Framework Branding & Naming Guide

## Current Framework Identity

```
Framework Name:     SO Framework
Package Name:       so/framework
Database Name:      so-framework
Directory Name:     so-backend-framework (or so-framework if renamed)
```

## [*] Quick Rename Checklist

To completely rebrand the framework, change these files in order:

### Priority 1: Core Identity (Required)

- [ ] `.env` - Lines 2, 12
- [ ] `composer.json` - Line 2
- [ ] `database/migrations/generate-setup.php` - Run after .env change

### Priority 2: Documentation (Recommended)

- [ ] `README.md` - Title and references
- [ ] `SETUP.md` - References throughout
- [ ] `CONFIGURATION.md` - Examples
- [ ] `QUICK-START.md` - Examples

### Priority 3: Example Content (Optional)

- [ ] `resources/views/welcome.php` - Already uses config()
- [ ] `.env.example` - Default values

---

## [Note] Detailed Change Guide

### File 1: `.env`
**Location:** `/var/www/html/so-backend-framework/.env`

**Lines to Change:**
```bash
# Line 2 - Framework Display Name
APP_NAME="SO Framework"
# Change to: APP_NAME="Your Framework Name"

# Line 12 - Database Name
DB_DATABASE=so-framework
# Change to: DB_DATABASE=your-framework
```

**Impact:** Changes all runtime references (views, configs, database connections)

---

### File 2: `composer.json`
**Location:** `/var/www/html/so-backend-framework/composer.json`

**Lines to Change:**
```json
// Line 2 - Package Name
"name": "so/framework",
// Change to: "name": "vendor/your-framework",

// Line 3 - Description (optional)
"description": "Production-ready PHP framework...",
// Change to: "description": "Your custom description",
```

**After changing, run:**
```bash
composer dump-autoload
```

---

### File 3: `.env.example`
**Location:** `/var/www/html/so-backend-framework/.env.example`

**Lines to Change:**
```bash
# Line 2
APP_NAME="SO Framework"
# Change to: APP_NAME="Your Framework Name"

# Line 12
DB_DATABASE=so-framework
# Change to: DB_DATABASE=your-framework
```

**Purpose:** Template for new installations

---

### File 4: `database/migrations/generate-setup.php`
**Location:** `/var/www/html/so-backend-framework/database/migrations/generate-setup.php`

**Action Required:**
```bash
# Run generator to create setup.sql with your new names
php database/migrations/generate-setup.php
```

**What it does:**
- Reads `APP_NAME` and `DB_DATABASE` from `.env`
- Generates `setup.sql` with correct database name
- Includes framework name in SQL comments

**Output:** `database/migrations/setup.sql` (auto-generated, don't edit manually)

---

### File 5: `README.md`
**Location:** `/var/www/html/so-backend-framework/README.md`

**Lines to Change:**
```markdown
# Line 1 - Title
# SO Backend Framework
# Change to: # Your Framework Name

# Line 3 - Description
A production-ready PHP framework...
# Update description as needed

# Throughout - References to "SO Backend Framework"
# Find and replace with your framework name
```

---

### File 6: `SETUP.md`
**Location:** `/var/www/html/so-backend-framework/SETUP.md`

**Lines to Change:**
```markdown
# Line 1 - Title
# Setup Guide - SO Backend Framework
# Change to: # Setup Guide - Your Framework Name

# Throughout document
- References to "SO Framework"
- Example database names
- Example commands
```

**Search and Replace:**
```bash
# Find: SO Framework
# Replace: Your Framework Name

# Find: so-framework
# Replace: your-framework
```

---

### File 7: `CONFIGURATION.md`
**Location:** `/var/www/html/so-backend-framework/CONFIGURATION.md`

**Lines to Change:**
```markdown
# Examples showing "SO Framework"
# Update to show your framework name
```

---

### File 8: `QUICK-START.md`
**Location:** `/var/www/html/so-backend-framework/QUICK-START.md`

**Lines to Change:**
```markdown
# Examples showing framework names
# Update examples to use your chosen name
```

---

### File 9: `resources/views/welcome.php`
**Location:** `/var/www/html/so-backend-framework/resources/views/welcome.php`

**Current Status:** [x] Already Dynamic!

```php
// Already uses config(), no changes needed!
<title><?= htmlspecialchars(config('app.name')) ?></title>
<h1>[->] <?= htmlspecialchars(config('app.name')) ?></h1>
```

**Note:** This file automatically displays whatever you set in `.env`

---

## [Bot] Automated Rename Script

Here's a bash script to rename everything at once:

**File:** `rename-framework.sh`

```bash
#!/bin/bash

# Framework Rename Script
# Usage: ./rename-framework.sh "New Framework Name" "new-framework" "vendor/package"

NEW_NAME="$1"           # Display name (e.g., "My Framework")
NEW_DB="$2"             # Database name (e.g., "my-framework")
NEW_PACKAGE="$3"        # Package name (e.g., "vendor/my-framework")

if [ -z "$NEW_NAME" ] || [ -z "$NEW_DB" ]; then
    echo "Usage: ./rename-framework.sh 'Framework Name' 'database-name' 'vendor/package'"
    exit 1
fi

echo "[~] Renaming framework..."
echo "  Name: $NEW_NAME"
echo "  Database: $NEW_DB"
echo "  Package: $NEW_PACKAGE"
echo ""

# Update .env
echo "✏️  Updating .env..."
sed -i "s/APP_NAME=\".*\"/APP_NAME=\"$NEW_NAME\"/" .env
sed -i "s/DB_DATABASE=.*/DB_DATABASE=$NEW_DB/" .env

# Update .env.example
echo "✏️  Updating .env.example..."
sed -i "s/APP_NAME=\".*\"/APP_NAME=\"$NEW_NAME\"/" .env.example
sed -i "s/DB_DATABASE=.*/DB_DATABASE=$NEW_DB/" .env.example

# Update composer.json if package name provided
if [ -n "$NEW_PACKAGE" ]; then
    echo "✏️  Updating composer.json..."
    sed -i "s/\"name\": \".*\"/\"name\": \"$NEW_PACKAGE\"/" composer.json
fi

# Regenerate SQL
echo "🔨 Regenerating setup.sql..."
php database/migrations/generate-setup.php

# Update documentation
echo "✏️  Updating documentation..."
find . -name "*.md" -type f -exec sed -i "s/SO Framework/$NEW_NAME/g" {} +
find . -name "*.md" -type f -exec sed -i "s/so-framework/$NEW_DB/g" {} +

echo ""
echo "[x] Framework renamed successfully!"
echo ""
echo "Next steps:"
echo "  1. Review changes: git diff"
echo "  2. Run composer: composer dump-autoload"
echo "  3. Import database: mysql -u root -p < database/migrations/setup.sql"
echo ""
```

**Make it executable:**
```bash
chmod +x rename-framework.sh
```

**Usage:**
```bash
./rename-framework.sh "My Awesome Framework" "awesome-framework" "mycompany/awesome"
```

---

## [Chart] File Change Summary Table

| File | Lines to Change | Auto-Generated? | Required? |
|------|----------------|-----------------|-----------|
| `.env` | 2, 12 | No | [x] Required |
| `composer.json` | 2-3 | No | [x] Required |
| `.env.example` | 2, 12 | No | [!] Recommended |
| `generate-setup.php` | Run it | N/A | [x] Required |
| `setup.sql` | N/A | [x] Yes | Auto-generated |
| `README.md` | Throughout | No | [!] Recommended |
| `SETUP.md` | Throughout | No | [!] Recommended |
| `CONFIGURATION.md` | Examples | No | [!] Recommended |
| `QUICK-START.md` | Examples | No | [!] Recommended |
| `welcome.php` | None | Already dynamic | [x] Done |

---

## [*] Quick Rename: 3-Step Process

### Step 1: Update Core Identity (2 minutes)

```bash
# Edit .env
nano .env
# Change: APP_NAME="Your Name"
# Change: DB_DATABASE=your-db

# Edit composer.json
nano composer.json
# Change: "name": "vendor/your-package"
```

### Step 2: Regenerate SQL (10 seconds)

```bash
php database/migrations/generate-setup.php
composer dump-autoload
```

### Step 3: Update Docs (5 minutes)

```bash
# Find and replace in documentation
find . -name "*.md" -exec sed -i 's/SO Framework/Your Framework/g' {} +
find . -name "*.md" -exec sed -i 's/so-framework/your-framework/g' {} +
```

**Total Time:** ~7 minutes to completely rebrand! ⚡

---

## 🔍 Verification Checklist

After renaming, verify everything works:

```bash
# Check environment
php -r "require 'vendor/autoload.php';
        use Core\Support\Env;
        Env::load('.env');
        echo 'Name: ' . env('APP_NAME') . PHP_EOL;
        echo 'DB: ' . env('DB_DATABASE') . PHP_EOL;"

# Check SQL
head -5 database/migrations/setup.sql

# Test homepage
curl http://localhost:8000 | grep -i "title"

# Test API
curl http://localhost:8000/api/test

# Check composer
composer validate
```

Expected output:
```
[x] Name: Your Framework Name
[x] DB: your-database
[x] SQL contains your database name
[x] Homepage shows your name
[x] API responds correctly
[x] Composer valid
```

---

## [Note] Notes

### What Changes Automatically?

When you update `.env`, these change automatically (no file editing needed):

[x] Page titles and headings (use `config('app.name')`)
[x] Database connections (use `config('database.connections.mysql.database')`)
[x] API responses that reference config
[x] Error pages
[x] Log entries

### What Requires Manual Update?

[X] Documentation files (README, SETUP, etc.)
[X] Hard-coded references in custom code
[X] Comments in source files
[X] Package name in composer.json

### Best Practice

Always use `config()` in your code, never hard-code the framework name:

```php
// [x] Good - Dynamic
$name = config('app.name');

// [X] Bad - Hard-coded
$name = "SO Framework";
```

---

## [?] Troubleshooting

### Issue: Changes not reflecting

**Solution:**
```bash
# Clear any caches
rm -rf storage/cache/*
rm -rf bootstrap/cache/*

# Regenerate autoloader
composer dump-autoload
```

### Issue: Database name mismatch

**Solution:**
```bash
# Ensure .env matches setup.sql
grep DB_DATABASE .env
grep "USE" database/migrations/setup.sql

# If different, regenerate:
php database/migrations/generate-setup.php
```

### Issue: Composer errors

**Solution:**
```bash
# Validate composer.json
composer validate

# Reinstall if needed
rm -rf vendor
composer install
```

---

## [!] Summary

To rename your framework:

1. **Edit `.env`** → Change `APP_NAME` and `DB_DATABASE`
2. **Edit `composer.json`** → Change package `name`
3. **Run generator** → `php database/migrations/generate-setup.php`
4. **Update docs** → Find/replace in `.md` files (optional)
5. **Test** → Verify everything works

**That's it!** Your framework is now completely rebranded! [->]

For questions, see [CONFIGURATION.md](CONFIGURATION.md) for detailed documentation.
