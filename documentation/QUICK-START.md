# Quick Start Guide

## ⚡ Change Framework Name in One Place

### Step 1: Edit .env

```bash
nano .env
```

Change these two lines:
```bash
APP_NAME="Your Framework Name Here"
DB_DATABASE=your-database-name
```

### Step 2: Regenerate SQL (if database name changed)

```bash
php database/migrations/generate-setup.php
```

### Step 3: Import Database

```bash
mysql -u root -p < database/migrations/setup.sql
```

### Step 4: Done! [x]

Your framework name now appears everywhere:
- [x] Page titles
- [x] Welcome page
- [x] API responses
- [x] Database name

## [*] What Gets Updated Automatically

When you change `APP_NAME="My Framework"` in `.env`:

| Location | What Changes |
|----------|-------------|
| **Views** | `<title>`, `<h1>`, all references |
| **API** | Response metadata |
| **Logs** | Application name in logs |
| **Config** | `config('app.name')` everywhere |

When you change `DB_DATABASE=mydb` in `.env`:

| Location | What Changes |
|----------|-------------|
| **Generated SQL** | `CREATE DATABASE mydb` |
| **Connections** | All database connections |
| **Models** | All model queries |

## [Note] Examples

### Change to "My Awesome API"

```bash
# Edit .env
APP_NAME="My Awesome API"
DB_DATABASE=awesome-api

# Regenerate SQL
php database/migrations/generate-setup.php

# Import
mysql -u root -p < database/migrations/setup.sql
```

Result:
- Pages show "My Awesome API"
- Database named `awesome-api`
- Everything connected!

### Use in Your Code

```php
// Automatically gets "My Awesome API"
$name = config('app.name');

// In views
<title><?= config('app.name') ?></title>

// In controllers
return Response::view('home', [
    'appName' => config('app.name')
]);
```

## [->] Test Your Changes

```bash
# Test homepage
curl http://localhost:8000

# Test API
curl http://localhost:8000/api/test

# Check database
mysql -u root -p -e "SHOW DATABASES LIKE 'your-database-name';"
```

## [Docs] More Details

See [CONFIGURATION.md](CONFIGURATION.md) for complete documentation.

## [!] That's It!

Change name **once** in `.env` → Works **everywhere** automatically!
