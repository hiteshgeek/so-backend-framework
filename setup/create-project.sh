#!/bin/bash

###############################################################################
# Framework Project Creator
#
# Creates a clean copy of the framework for a new project.
# Excludes documentation, tests, demos, and development files.
# Cleans example data from necessary files.
#
# Usage:
#   ./setup/create-project.sh /path/to/new-project [--keep-docs]
#   ./setup/create-project.sh /var/www/html/my-app
#   ./setup/create-project.sh ../my-app --keep-docs
###############################################################################

set -e  # Exit on error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Get script directory
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
SOURCE_DIR="$(dirname "$SCRIPT_DIR")"

# Validate source directory
if [ ! -d "$SOURCE_DIR" ]; then
    echo -e "${RED}Error: Source directory not found: $SOURCE_DIR${NC}"
    exit 1
fi

if [ ! -f "$SOURCE_DIR/core/Application.php" ]; then
    echo -e "${RED}Error: Not a valid framework directory (core/Application.php not found)${NC}"
    exit 1
fi

# Parse arguments
KEEP_DOCS=false
FORCE=false
DEST_DIR=""

for arg in "$@"; do
    case $arg in
        --keep-docs)
            KEEP_DOCS=true
            ;;
        --force)
            FORCE=true
            ;;
        *)
            if [ -z "$DEST_DIR" ]; then
                DEST_DIR="$arg"
            fi
            ;;
    esac
done

# Check if destination is provided
if [ -z "$DEST_DIR" ]; then
    echo -e "${RED}Error: Destination path required${NC}"
    echo ""
    echo "Usage:"
    echo "  ./setup/create-project.sh /path/to/new-project [options]"
    echo ""
    echo "Examples:"
    echo "  ./setup/create-project.sh /var/www/html/my-app"
    echo "  ./setup/create-project.sh ../my-new-project --keep-docs"
    echo "  ./setup/create-project.sh /var/www/html/my-app --force"
    echo "  ./setup/create-project.sh ../my-app --keep-docs --force"
    echo ""
    echo "Options:"
    echo "  --keep-docs    Keep documentation files (docs/)"
    echo "  --force        Overwrite destination directory if it exists"
    exit 1
fi

# Check if destination exists
if [ -d "$DEST_DIR" ]; then
    if [ "$FORCE" = false ]; then
        echo -e "${RED}Error: Destination directory already exists: $DEST_DIR${NC}"
        echo -e "${YELLOW}Use --force to overwrite${NC}"
        exit 1
    else
        echo -e "${YELLOW}Warning: Destination directory exists and will be overwritten${NC}"
        echo -e "${YELLOW}Removing existing directory: $DEST_DIR${NC}"
        rm -rf "$DEST_DIR"
        echo -e "${GREEN}✓${NC} Existing directory removed"
    fi
fi

echo -e "${BLUE}╔════════════════════════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║         Framework Project Creator                         ║${NC}"
echo -e "${BLUE}╚════════════════════════════════════════════════════════════╝${NC}"
echo ""
echo -e "${YELLOW}Source:${NC}      $SOURCE_DIR"
echo -e "${YELLOW}Destination:${NC} $DEST_DIR"
echo -e "${YELLOW}Keep docs:${NC}   $KEEP_DOCS"
echo -e "${YELLOW}Force:${NC}       $FORCE"
echo ""

# Check PHP version and required extensions
echo -e "${BLUE}[0/12]${NC} Checking PHP requirements..."

# Check PHP version
PHP_VERSION=$(php -r "echo PHP_VERSION;")
PHP_MAJOR=$(php -r "echo PHP_MAJOR_VERSION;")
PHP_MINOR=$(php -r "echo PHP_MINOR_VERSION;")

if [ "$PHP_MAJOR" -lt 8 ] || ([ "$PHP_MAJOR" -eq 8 ] && [ "$PHP_MINOR" -lt 3 ]); then
    echo -e "${RED}✗ PHP 8.3 or higher required (found: $PHP_VERSION)${NC}"
    exit 1
fi
echo -e "${GREEN}✓${NC} PHP version: $PHP_VERSION"

# Check required extensions
REQUIRED_EXTENSIONS=("json" "mbstring" "openssl" "pdo" "intl")
MISSING_EXTENSIONS=()

for ext in "${REQUIRED_EXTENSIONS[@]}"; do
    if ! php -m | grep -qi "^$ext$"; then
        MISSING_EXTENSIONS+=("$ext")
    fi
done

if [ ${#MISSING_EXTENSIONS[@]} -gt 0 ]; then
    echo -e "${RED}✗ Missing required PHP extensions: ${MISSING_EXTENSIONS[*]}${NC}"
    echo ""
    echo -e "${YELLOW}Install missing extensions:${NC}"
    echo ""
    echo "Ubuntu/Debian:"
    echo "  sudo apt-get install php8.3-${MISSING_EXTENSIONS[0]}"
    echo ""
    echo "CentOS/RHEL:"
    echo "  sudo yum install php-${MISSING_EXTENSIONS[0]}"
    echo ""
    echo "macOS (Homebrew):"
    echo "  brew install php@8.3"
    echo ""
    echo "After installation, restart your web server and try again."
    exit 1
fi
echo -e "${GREEN}✓${NC} All required extensions installed: ${REQUIRED_EXTENSIONS[*]}"

# Check image processing extensions (optional but recommended)
IMAGE_EXTENSIONS=()
if php -m | grep -qi "^imagick$"; then
    IMAGE_EXTENSIONS+=("imagick")
fi
if php -m | grep -qi "^gd$"; then
    IMAGE_EXTENSIONS+=("gd")
fi

if [ ${#IMAGE_EXTENSIONS[@]} -gt 0 ]; then
    echo -e "${GREEN}✓${NC} Image processing extensions: ${IMAGE_EXTENSIONS[*]}"
else
    echo -e "${YELLOW}⚠${NC}  No image extensions found (imagick/gd). Image processing features will be limited."
    echo -e "${YELLOW}  Install imagick or gd for image manipulation, watermarks, and variants.${NC}"
fi
echo ""

# Create destination directory
echo -e "${BLUE}[1/12]${NC} Creating destination directory..."
mkdir -p "$DEST_DIR"

# Copy framework structure
echo -e "${BLUE}[2/12]${NC} Copying framework files..."

# Build rsync exclude list
RSYNC_EXCLUDES=(
    # Version control & dependencies
    '.git'
    'node_modules'
    'vendor'
    '.env'
    'composer.lock'

    # IDE & Editor settings
    '.vscode'
    '.idea'
    '.claude'

    # Testing files
    'tests'
    'phpunit.xml'
    '.phpunit.cache'
    '.phpunit.result.cache'

    # Development files
    'todo'
    'setup'
    '*.log'
    '*.cache'
    'storage/sessions/*'
    'storage/cache/*'
    'storage/logs/*'

    # Demo documentation system
    'docs'
    'config/docs-navigation.php'

    # Demo controllers (keep Auth API controllers)
    'app/Controllers/DocsController.php'
    'app/Controllers/DashboardController.php'
    'app/Controllers/Auth/AuthController.php'
    'app/Controllers/Auth/PasswordController.php'
    'app/Controllers/Api/Demo'

    # Demo services & repositories
    'app/Services/Payment'
    'app/Repositories/Product'

    # Demo models (keep User.php)
    'app/Models/Category.php'
    'app/Models/Order.php'
    'app/Models/Product.php'
    'app/Models/Review.php'
    'app/Models/Tag.php'

    # Demo jobs & notifications
    'app/Jobs/TestJob.php'
    'app/Notifications/OrderApprovalNotification.php'
    'app/Notifications/WelcomeNotification.php'

    # Demo routes
    'routes/web/auth.php'
    'routes/web/dashboard.php'
    'routes/web/docs.php'
    'routes/api/demo.php'
    'routes/api/products.php'
    'routes/api/orders.php'

    # Demo views (will create new minimal welcome.php)
    'resources/views/welcome.php'
    'resources/views/auth'
    'resources/views/dashboard'
    'resources/views/docs'
    'resources/views/api/test.php'

    # Demo assets
    'public/assets/css/docs'
    'public/assets/css/auth'
    'public/assets/css/dashboard'
    'public/assets/css/pages/welcome.css'
    'public/assets/css/tools'
    'public/assets/js/docs'
    'public/assets/js/dashboard'
    'public/assets/js/tools'
)

# Build rsync command with excludes
RSYNC_CMD="rsync -a --quiet"
for exclude in "${RSYNC_EXCLUDES[@]}"; do
    RSYNC_CMD="$RSYNC_CMD --exclude='$exclude'"
done
RSYNC_CMD="$RSYNC_CMD '$SOURCE_DIR/' '$DEST_DIR/'"

eval $RSYNC_CMD

echo -e "${GREEN}✓${NC} Framework files copied"

# Create minimal welcome page with inline styles (self-contained)
echo -e "${BLUE}[3/12]${NC} Creating minimal welcome page..."

cat > "$DEST_DIR/resources/views/welcome.php" << 'WELCOME_EOF'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(config('app.name', 'My Application')) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: #f8fafc;
            color: #1e293b;
            line-height: 1.6;
        }

        .welcome-container {
            max-width: 600px;
            width: 100%;
            margin: 24px;
            padding: 48px 32px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }

        h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
            text-align: center;
        }

        .welcome-subtitle {
            font-size: 16px;
            color: #64748b;
            text-align: center;
            margin-bottom: 32px;
        }

        .next-steps { margin-bottom: 32px; }

        .next-steps h2 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .next-steps ul {
            list-style: none;
            padding: 0;
        }

        .next-steps li {
            padding: 8px 0;
            color: #64748b;
            font-size: 14px;
        }

        .next-steps li::before {
            content: "→ ";
            color: #2563eb;
            font-weight: 600;
            margin-right: 8px;
        }

        code {
            background: #f1f5f9;
            color: #0f172a;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Consolas', 'Monaco', monospace;
            font-size: 13px;
        }

        .info {
            text-align: center;
            padding-top: 24px;
            border-top: 1px solid #e2e8f0;
        }

        .info p {
            font-size: 12px;
            color: #94a3b8;
        }

        @media (prefers-color-scheme: dark) {
            body { background: #0f172a; color: #f1f5f9; }
            .welcome-container { background: #1e293b; border-color: #334155; }
            .welcome-subtitle, .next-steps li { color: #94a3b8; }
            code { background: #0f172a; color: #e2e8f0; }
            .info { border-color: #334155; }
            .info p { color: #64748b; }
        }

        @media (max-width: 480px) {
            .welcome-container { padding: 24px 16px; margin: 16px; }
            h1 { font-size: 24px; }
            .welcome-subtitle { font-size: 14px; }
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h1><?= htmlspecialchars(config('app.name', 'My Application')) ?></h1>
        <p class="welcome-subtitle">Your new application is ready to build.</p>

        <div class="next-steps">
            <h2>Next Steps</h2>
            <ul>
                <li>Configure your database in <code>.env</code></li>
                <li>Create your models in <code>app/Models/</code></li>
                <li>Build your controllers in <code>app/Controllers/</code></li>
                <li>Define your routes in <code>routes/</code></li>
                <li>Design your views in <code>resources/views/</code></li>
            </ul>
        </div>

        <div class="info">
            <p>Framework v<?= htmlspecialchars(config('app.version', '2.0.0')) ?> | PHP <?= PHP_VERSION ?></p>
        </div>
    </div>
</body>
</html>
WELCOME_EOF

echo -e "${GREEN}✓${NC} Minimal welcome page created"

# Create empty directories for new project
echo -e "${BLUE}[4/12]${NC} Creating empty directories..."

# Create empty controller directories (auth controllers already copied by rsync)
mkdir -p "$DEST_DIR/app/Controllers/Api/V1"
mkdir -p "$DEST_DIR/app/Controllers/Api/V2"
mkdir -p "$DEST_DIR/app/Controllers/Web"
mkdir -p "$DEST_DIR/app/Controllers/Internal"
find "$DEST_DIR/app/Controllers/Api/V1" -type d -empty -exec touch {}/.gitkeep \;
find "$DEST_DIR/app/Controllers/Api/V2" -type d -empty -exec touch {}/.gitkeep \;
find "$DEST_DIR/app/Controllers/Web" -type d -empty -exec touch {}/.gitkeep \;
find "$DEST_DIR/app/Controllers/Internal" -type d -empty -exec touch {}/.gitkeep \;

# Create empty directories with .gitkeep (services/models already copied by rsync)
mkdir -p "$DEST_DIR/app/Validation"
mkdir -p "$DEST_DIR/app/Validators"
mkdir -p "$DEST_DIR/app/Jobs"
mkdir -p "$DEST_DIR/app/Notifications"
mkdir -p "$DEST_DIR/app/Console/Commands"
touch "$DEST_DIR/app/Validation/.gitkeep"
touch "$DEST_DIR/app/Validators/.gitkeep"
touch "$DEST_DIR/app/Jobs/.gitkeep"
touch "$DEST_DIR/app/Notifications/.gitkeep"
touch "$DEST_DIR/app/Console/Commands/.gitkeep"

# Create empty view directories (errors folder already copied by rsync)
mkdir -p "$DEST_DIR/resources/views/layouts"
mkdir -p "$DEST_DIR/resources/views/components"
mkdir -p "$DEST_DIR/resources/views/emails"
touch "$DEST_DIR/resources/views/layouts/.gitkeep"
touch "$DEST_DIR/resources/views/components/.gitkeep"
touch "$DEST_DIR/resources/views/emails/.gitkeep"

# Create .gitkeep for routes
touch "$DEST_DIR/routes/web/.gitkeep"

echo -e "${GREEN}✓${NC} Empty directories created"

# Clean route files
echo -e "${BLUE}[5/12]${NC} Cleaning route files..."

# Clean web.php - remove demo requires
if [ -f "$DEST_DIR/routes/web.php" ]; then
    sed -i '/require.*\/web\/auth\.php/d' "$DEST_DIR/routes/web.php"
    sed -i '/require.*\/web\/dashboard\.php/d' "$DEST_DIR/routes/web.php"
    sed -i '/require.*\/web\/docs\.php/d' "$DEST_DIR/routes/web.php"
    sed -i '/Example route with parameters/,/whereNumber/d' "$DEST_DIR/routes/web.php"
    sed -i '/^$/N;/^\n$/D' "$DEST_DIR/routes/web.php"
fi

# Clean api.php - remove demo requires, keep auth routes
if [ -f "$DEST_DIR/routes/api.php" ]; then
    sed -i '/require.*\/api\/demo\.php/d' "$DEST_DIR/routes/api.php"
    sed -i '/require.*\/api\/products\.php/d' "$DEST_DIR/routes/api.php"
    sed -i '/require.*\/api\/orders\.php/d' "$DEST_DIR/routes/api.php"
    sed -i '/API route tester/,/name.*api\.test/d' "$DEST_DIR/routes/api.php"
    sed -i '/API v2 Routes/,/});/d' "$DEST_DIR/routes/api.php"
    sed -i '/^$/N;/^\n$/D' "$DEST_DIR/routes/api.php"
fi

echo -e "${GREEN}✓${NC} Route files cleaned"

# Create clean composer.json without dev dependencies
echo -e "${BLUE}[5.5/12]${NC} Creating clean composer.json..."
cat > "$DEST_DIR/composer.json" << 'COMPOSER_EOF'
{
    "name": "so/framework",
    "description": "Production-ready PHP framework",
    "type": "project",
    "license": "MIT",
    "require": {
        "php": "^8.3",
        "ext-json": "*",
        "ext-mbstring": "*",
        "ext-openssl": "*",
        "ext-pdo": "*",
        "ext-intl": "*"
    },
    "autoload": {
        "psr-4": {
            "Core\\": "core/",
            "App\\": "app/"
        },
        "files": [
            "core/Support/Helpers.php"
        ]
    },
    "config": {
        "optimize-autoloader": true,
        "preferred-install": "dist",
        "sort-packages": true
    },
    "minimum-stability": "stable",
    "prefer-stable": true
}
COMPOSER_EOF
echo -e "${GREEN}✓${NC} composer.json created (without dev dependencies)"

# Clean database seeders - remove all and create empty folder
echo -e "${BLUE}[6/12]${NC} Cleaning database seeders..."

# Clean database folder - remove all, recreate empty
rm -rf "$DEST_DIR/database/seeders"
rm -rf "$DEST_DIR/database/seeds"
rm -rf "$DEST_DIR/database/migrations"
mkdir -p "$DEST_DIR/database/seeders"
mkdir -p "$DEST_DIR/database/migrations"
touch "$DEST_DIR/database/seeders/.gitkeep"
touch "$DEST_DIR/database/migrations/.gitkeep"

echo -e "${GREEN}✓${NC} Database folders cleaned"

# Create storage directories
echo -e "${BLUE}[7/12]${NC} Creating storage directories..."
mkdir -p "$DEST_DIR/storage/sessions"
mkdir -p "$DEST_DIR/storage/cache"
mkdir -p "$DEST_DIR/storage/logs"
mkdir -p "$DEST_DIR/storage/uploads"

# Create .gitkeep files
touch "$DEST_DIR/storage/sessions/.gitkeep"
touch "$DEST_DIR/storage/cache/.gitkeep"
touch "$DEST_DIR/storage/logs/.gitkeep"
touch "$DEST_DIR/storage/uploads/.gitkeep"

echo -e "${GREEN}✓${NC} Storage directories created"

# Set permissions
echo -e "${BLUE}[8/12]${NC} Setting permissions..."
chmod -R 755 "$DEST_DIR"
chmod -R 775 "$DEST_DIR/storage"

if [ -d "$DEST_DIR/bootstrap/cache" ]; then
    chmod -R 775 "$DEST_DIR/bootstrap/cache"
fi

echo -e "${GREEN}✓${NC} Permissions set"

# Create .env file
echo -e "${BLUE}[9/12]${NC} Creating environment file..."

if [ -f "$DEST_DIR/.env.example" ]; then
    cp "$DEST_DIR/.env.example" "$DEST_DIR/.env"

    # Generate random APP_KEY
    if command -v openssl &> /dev/null; then
        APP_KEY=$(openssl rand -base64 32)
        sed -i "s|APP_KEY=.*|APP_KEY=$APP_KEY|" "$DEST_DIR/.env" 2>/dev/null || true
    fi

    echo -e "${GREEN}✓${NC} .env file created from .env.example"
else
    echo -e "${YELLOW}⚠${NC}  .env.example not found, skipping .env creation"
fi

# Setup media system (file uploads & image processing)
echo -e "${BLUE}[10/12]${NC} Setting up media system..."

# Create rpkfiles directory if it doesn't exist
RPKFILES_PATH="/var/www/html/rpkfiles"
if [ ! -d "$RPKFILES_PATH" ]; then
    echo -e "${YELLOW}Creating shared media directory: $RPKFILES_PATH${NC}"
    if mkdir -p "$RPKFILES_PATH" 2>/dev/null; then
        chmod 755 "$RPKFILES_PATH"
        echo -e "${GREEN}✓${NC} Created $RPKFILES_PATH"

        # Try to set ownership to www-data if running as root
        if [ "$EUID" -eq 0 ] || [ "$(id -u)" -eq 0 ]; then
            if id -u www-data >/dev/null 2>&1; then
                chown www-data:www-data "$RPKFILES_PATH" 2>/dev/null || true
                echo -e "${GREEN}✓${NC} Set ownership to www-data:www-data"
            fi
        fi
    else
        echo -e "${YELLOW}⚠${NC}  Failed to create $RPKFILES_PATH (permission denied)"
        echo -e "${YELLOW}  Run manually: sudo mkdir -p $RPKFILES_PATH && sudo chmod 755 $RPKFILES_PATH${NC}"
    fi
else
    echo -e "${GREEN}✓${NC} Media directory already exists: $RPKFILES_PATH"
fi

# Add media configuration to .env if file exists
if [ -f "$DEST_DIR/.env" ]; then
    # Check if media config already exists
    if ! grep -q "MEDIA_PATH" "$DEST_DIR/.env"; then
        echo "" >> "$DEST_DIR/.env"
        echo "# Media & File Uploads" >> "$DEST_DIR/.env"
        echo "MEDIA_PATH=/var/www/html/rpkfiles" >> "$DEST_DIR/.env"
        echo "MEDIA_URL=/media" >> "$DEST_DIR/.env"
        echo "MEDIA_DISK=media" >> "$DEST_DIR/.env"
        echo "MEDIA_MAX_SIZE=10240" >> "$DEST_DIR/.env"
        echo "MEDIA_QUEUE_ENABLED=true" >> "$DEST_DIR/.env"
        echo "MEDIA_QUEUE_CONNECTION=database" >> "$DEST_DIR/.env"
        echo "" >> "$DEST_DIR/.env"
        echo "# Image Processing" >> "$DEST_DIR/.env"
        echo "IMAGE_DRIVER=imagick" >> "$DEST_DIR/.env"
        echo "WATERMARK_ENABLED=false" >> "$DEST_DIR/.env"
        echo -e "${GREEN}✓${NC} Added media configuration to .env"
    else
        echo -e "${GREEN}✓${NC} Media configuration already in .env"
    fi
fi

echo -e "${GREEN}✓${NC} Media system setup complete"

# Create minimal README
echo -e "${BLUE}[11/12]${NC} Creating project README..."

PROJECT_NAME=$(basename "$DEST_DIR")

cat > "$DEST_DIR/README.md" << EOF
# $PROJECT_NAME

A PHP application built with the SO Framework.

## Requirements

- **PHP 8.3 or higher**
- **MySQL 8.0+** or **PostgreSQL 14+**
- **Composer**
- **Required PHP Extensions:**
  - \`ext-json\` - JSON encoding/decoding
  - \`ext-mbstring\` - Multi-byte string support
  - \`ext-openssl\` - Encryption and security
  - \`ext-pdo\` - Database connectivity
  - \`ext-intl\` - Internationalization (required)
- **Optional PHP Extensions (for media features):**
  - \`ext-imagick\` - Advanced image processing (recommended)
  - \`ext-gd\` - Basic image processing (fallback)

### Verify Requirements

\`\`\`bash
# Check PHP version
php -v

# Check installed extensions
php -m | grep -E "json|mbstring|openssl|pdo|intl"

# Or use the framework validator
php -r "
\\\$required = ['json', 'mbstring', 'openssl', 'pdo', 'intl'];
\\\$missing = array_filter(\\\$required, fn(\\\$ext) => !extension_loaded(\\\$ext));
if (\\\$missing) {
    echo '❌ Missing: ' . implode(', ', \\\$missing) . PHP_EOL;
    exit(1);
}
echo '✓ All required extensions installed' . PHP_EOL;
"
\`\`\`

### Installing Missing Extensions

**Ubuntu/Debian:**
\`\`\`bash
sudo apt-get install php8.3-intl php8.3-mbstring php8.3-xml
sudo service apache2 restart
\`\`\`

**CentOS/RHEL:**
\`\`\`bash
sudo yum install php-intl php-mbstring
sudo systemctl restart httpd
\`\`\`

**macOS (Homebrew):**
\`\`\`bash
brew install php@8.3
# All extensions included by default
\`\`\`

## Quick Start

\`\`\`bash
# 1. Install dependencies
composer install

# 2. Configure environment
cp .env.example .env
# Edit .env with your database credentials

# 3. Set up database
mysql -u root -p < database/schema.sql

# 4. Run migrations (for media system)
php artisan migrate

# 5. Set permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# 6. Start queue worker (for async image processing)
php artisan queue:work &

# 7. Configure web server to point to public/ directory
\`\`\`

## Directory Structure

\`\`\`
app/                    Application code (your code goes here)
├── Controllers/        HTTP controllers
│   ├── Auth/          Authentication controllers (empty)
│   └── User/          User controllers (empty)
├── Models/            Database models (empty)
├── Services/          Business logic services
│   ├── Auth/          Auth services (empty)
│   └── User/          User services (empty)
└── Validation/        Validation rules (empty)

core/                   Framework core (DO NOT MODIFY)
config/                 Configuration files
routes/                 Route definitions
├── web.php            Web routes (HTML)
├── api.php            API routes (JSON)
├── web/               Web route modules (empty)
└── api/               API route modules (empty)
database/               Database files
├── migrations/        Database migrations (empty)
└── seeders/           Database seeders (empty)
resources/              Views and assets
public/                 Web root (point your server here)
storage/                File storage
vendor/                 Composer dependencies (run composer install)
\`\`\`

## Available Routes

### Web Routes (routes/web.php)
- \`GET  /\` - Home page (welcome.php)

Add your routes in \`routes/web/\` and include them in \`routes/web.php\`.

### API Routes (routes/api.php)
Add your API routes in \`routes/api/\` and include them in \`routes/api.php\`.

## Getting Started

1. Create your models in \`app/Models/\`
2. Create your services in \`app/Services/\`
3. Create your controllers in \`app/Controllers/\`
4. Add your routes in \`routes/\`
5. Create your views in \`resources/views/\`

## Media System (File Uploads & Image Processing)

The framework includes a comprehensive media system with:
- File uploads to shared directory (\`/var/www/html/rpkfiles\`)
- Image processing (resize, crop, rotate, filters)
- Automatic thumbnail & variant generation
- Watermark support (text and image overlays)
- Queue-based async processing

### Basic Usage

\`\`\`php
// Upload and create database entry
\$media = \$request->file('image')->storeAndCreate('products');
echo \$media->url();  // Public URL

// Upload with variants and watermark
\$media = \$request->file('photo')->storeAndCreate('gallery', [
    'variants' => true,
    'watermark' => 'copyright'
]);

// Access variant URLs
echo \$media->url('thumb');   // 150x150 thumbnail
echo \$media->url('medium');  // 640x480 resized
\`\`\`

### Configuration

Edit \`.env\` for media settings:
- \`MEDIA_PATH\` - Storage directory (default: /var/www/html/rpkfiles)
- \`MEDIA_MAX_SIZE\` - Max upload size in KB (default: 10240)
- \`IMAGE_DRIVER\` - Image processor: imagick or gd
- \`WATERMARK_ENABLED\` - Enable/disable watermarks

See \`docs/features/file-uploads.md\` for complete documentation.

## Documentation

$(if [ "$KEEP_DOCS" = true ]; then
    echo "Visit \`/docs\` in your application for full framework documentation."
else
    echo "Documentation was not included in this copy. Use --keep-docs flag if needed."
fi)

## Development

\`\`\`bash
# Run development server
php -S localhost:8000 -t public

# Watch for asset changes (if using build tools)
npm run dev
\`\`\`

## Production Deployment

1. Set \`APP_ENV=production\` in .env
2. Set \`APP_DEBUG=false\` in .env
3. Configure your web server (Apache/Nginx) to point to \`public/\`
4. Ensure \`storage/\` and \`bootstrap/cache/\` are writable
5. Enable HTTPS
6. Set secure session cookies

## Security

- Change APP_KEY in .env to a random 32-character string
- Never commit .env file to version control
- Keep vendor/ updated with \`composer update\`
- Review security hardening guide in docs/

## License

Proprietary - All rights reserved
EOF

echo -e "${GREEN}✓${NC} README.md created"

# Copy setup scripts (vhost install/cleanup)
echo -e "${BLUE}[12/12]${NC} Copying setup scripts..."
mkdir -p "$DEST_DIR/setup"
cp "$SOURCE_DIR/setup/install-vhost-sixorbit.sh" "$DEST_DIR/setup/"
cp "$SOURCE_DIR/setup/cleanup-vhost-sixorbit.sh" "$DEST_DIR/setup/"
chmod +x "$DEST_DIR/setup/install-vhost-sixorbit.sh"
chmod +x "$DEST_DIR/setup/cleanup-vhost-sixorbit.sh"
echo -e "${GREEN}✓${NC} Setup scripts copied (install-vhost-sixorbit.sh, cleanup-vhost-sixorbit.sh)"

# Initialize git repository (optional)
if command -v git &> /dev/null; then
    cd "$DEST_DIR"
    git init --quiet

    # Create .gitignore
    cat > .gitignore << 'EOF'
# Environment
.env
.env.backup
.env.production

# Dependencies
/vendor/
/node_modules/

# IDE
.idea/
.vscode/
*.swp
*.swo
*~
.phpintel/
_ide_helper.php
.phpstorm.meta.php

# OS
.DS_Store
.DS_Store?
._*
.Spotlight-V100
.Trashes
ehthumbs.db
Thumbs.db

# Storage
/storage/sessions/*
!/storage/sessions/.gitkeep
/storage/cache/*
!/storage/cache/.gitkeep
/storage/logs/*
!/storage/logs/.gitkeep
/storage/uploads/*
!/storage/uploads/.gitkeep

# Build
/public/build/
/public/hot
/public/storage
/public/mix-manifest.json

# Temporary files
*.log
*.cache
*.tmp
.phpunit.result.cache
.php-cs-fixer.cache

# Composer
/vendor/
composer.lock
EOF

    git add .
    git commit -m "Initial commit - Clean framework installation" --quiet

    echo -e "${GREEN}✓${NC} Git repository initialized"
else
    echo -e "${YELLOW}⚠${NC}  Git not found, skipping repository initialization"
fi

# Summary
echo ""
echo -e "${GREEN}╔════════════════════════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║         Project Created Successfully!                      ║${NC}"
echo -e "${GREEN}╚════════════════════════════════════════════════════════════╝${NC}"
echo ""
echo -e "${YELLOW}Next steps:${NC}"
echo ""
echo -e "  1. ${BLUE}cd $DEST_DIR${NC}"
echo -e "  2. ${BLUE}composer install${NC}"
echo -e "  3. ${BLUE}Edit .env file (database, JWT secret)${NC}"
echo -e "  4. ${BLUE}Import database schema${NC}"
echo -e "  5. ${BLUE}sudo bash setup/install-vhost-sixorbit.sh${NC} (sets up virtual host)"
echo -e "  6. Open ${BLUE}http://sixorbit.local${NC} in browser"
echo ""
echo -e "${YELLOW}Alternative (without vhost):${NC}"
echo -e "  ${BLUE}php -S localhost:8000 -t public${NC}"
echo ""
echo -e "${BLUE}Media System Notes:${NC}"
echo -e "  • Shared directory: ${GREEN}/var/www/html/rpkfiles${NC}"
echo -e "  • Upload size limit: ${GREEN}10MB${NC} (configurable in .env: MEDIA_MAX_SIZE)"
if [ ${#IMAGE_EXTENSIONS[@]} -gt 0 ]; then
    echo -e "  • Image processing: ${GREEN}Enabled${NC} (${IMAGE_EXTENSIONS[*]})"
    echo -e "  • Features: Resize, crop, watermarks, variants, thumbnails"
else
    echo -e "  • Image processing: ${YELLOW}Limited${NC} (install imagick or gd for full features)"
fi
echo -e "  • Queue: ${GREEN}Enabled${NC} for async variant generation"
echo -e "  • Documentation: See ${BLUE}docs/features/file-uploads.md${NC}"
echo ""
echo -e "${BLUE}What was excluded:${NC}"
echo -e "  • Documentation system (docs/, routes, controllers, assets)"
echo -e "  • Demo dashboard (views, routes, controller, assets)"
echo -e "  • Demo web auth UI (login/register pages, views)"
echo -e "  • Demo models (Category, Order, Product, Review, Tag)"
echo -e "  • Demo API endpoints (/api/demo, /api/products, /api/orders)"
echo -e "  • Test files, development files (tests/, todo/)"
echo ""
echo -e "${GREEN}What was included:${NC}"
echo -e "  ✓ Complete auth system (JWT-based API authentication)"
echo -e "  ✓ Auth controllers: AuthApiController, PasswordApiController, UserApiController"
echo -e "  ✓ Auth services: AuthenticationService, PasswordResetService, UserService"
echo -e "  ✓ User model with authentication methods"
echo -e "  ✓ Auth routes: /api/auth/*, /api/users/*"
echo -e "  ✓ Media system: File uploads, image processing, watermarks, variants"
echo -e "  ✓ Media routes: /files/* (upload, view, download)"
echo -e "  ✓ All middleware (8 files): Auth, JWT, CORS, CSRF, Throttle, etc."
echo -e "  ✓ All providers (6 files): Session, Cache, Queue, Notifications, Activity, Media"
echo -e "  ✓ Clean minimal welcome page"
echo -e "  ✓ Theme toggle (dark/light mode)"
echo -e "  ✓ Setup scripts (install-vhost-sixorbit.sh, cleanup-vhost-sixorbit.sh)"
echo ""
echo -e "${BLUE}Empty directories (ready for your code):${NC}"
echo -e "  • app/Controllers/Api/V1/, V2/, Web/, Internal/"
echo -e "  • app/Validation/, Validators/, Repositories/, Jobs/, Notifications/"
echo -e "  • resources/views/layouts/, components/, emails/"
echo ""
echo -e "${GREEN}Your clean framework is ready at:${NC}"
echo -e "${GREEN}$DEST_DIR${NC}"
echo ""
