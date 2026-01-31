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

# Parse arguments
KEEP_DOCS=false
DEST_DIR=""

for arg in "$@"; do
    case $arg in
        --keep-docs)
            KEEP_DOCS=true
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
    echo "  ./setup/create-project.sh /path/to/new-project [--keep-docs]"
    echo ""
    echo "Examples:"
    echo "  ./setup/create-project.sh /var/www/html/my-app"
    echo "  ./setup/create-project.sh ../my-new-project --keep-docs"
    echo ""
    echo "Options:"
    echo "  --keep-docs    Keep documentation files (docs/)"
    exit 1
fi

# Check if destination exists
if [ -d "$DEST_DIR" ]; then
    echo -e "${RED}Error: Destination directory already exists: $DEST_DIR${NC}"
    exit 1
fi

echo -e "${BLUE}╔════════════════════════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║         Framework Project Creator                         ║${NC}"
echo -e "${BLUE}╚════════════════════════════════════════════════════════════╝${NC}"
echo ""
echo -e "${YELLOW}Source:${NC}      $SOURCE_DIR"
echo -e "${YELLOW}Destination:${NC} $DEST_DIR"
echo -e "${YELLOW}Keep docs:${NC}   $KEEP_DOCS"
echo ""

# Create destination directory
echo -e "${BLUE}[1/10]${NC} Creating destination directory..."
mkdir -p "$DEST_DIR"

# Copy framework structure
echo -e "${BLUE}[2/10]${NC} Copying framework files..."

# Build rsync exclude list
RSYNC_EXCLUDES=(
    '.git'
    'node_modules'
    '.env'
    'vendor'
    'tests'
    'todo'
    'setup'
    '*.log'
    '*.cache'
    'storage/sessions/*'
    'storage/cache/*'
    'storage/logs/*'
)

# Add docs to excludes if not keeping
if [ "$KEEP_DOCS" = false ]; then
    RSYNC_EXCLUDES+=('docs')
fi

# Build rsync command with excludes
RSYNC_CMD="rsync -a --quiet"
for exclude in "${RSYNC_EXCLUDES[@]}"; do
    RSYNC_CMD="$RSYNC_CMD --exclude='$exclude'"
done
RSYNC_CMD="$RSYNC_CMD '$SOURCE_DIR/' '$DEST_DIR/'"

eval $RSYNC_CMD

echo -e "${GREEN}✓${NC} Framework files copied"

# Remove demo and development files
echo -e "${BLUE}[3/10]${NC} Removing demo and development files..."

# Clean app directories - remove all contents, recreate empty with .gitkeep
# Controllers
rm -rf "$DEST_DIR/app/Controllers"
mkdir -p "$DEST_DIR/app/Controllers/Auth"
mkdir -p "$DEST_DIR/app/Controllers/User"
mkdir -p "$DEST_DIR/app/Controllers/Api/V1"
mkdir -p "$DEST_DIR/app/Controllers/Api/V2"
mkdir -p "$DEST_DIR/app/Controllers/Web"
mkdir -p "$DEST_DIR/app/Controllers/Internal"
find "$DEST_DIR/app/Controllers" -type d -empty -exec touch {}/.gitkeep \;

# Services
rm -rf "$DEST_DIR/app/Services"
mkdir -p "$DEST_DIR/app/Services/Auth"
mkdir -p "$DEST_DIR/app/Services/User"
find "$DEST_DIR/app/Services" -type d -empty -exec touch {}/.gitkeep \;

# Models
rm -rf "$DEST_DIR/app/Models"
mkdir -p "$DEST_DIR/app/Models"
touch "$DEST_DIR/app/Models/.gitkeep"

# Validation
rm -rf "$DEST_DIR/app/Validation"
mkdir -p "$DEST_DIR/app/Validation"
touch "$DEST_DIR/app/Validation/.gitkeep"

# Validators
rm -rf "$DEST_DIR/app/Validators"
mkdir -p "$DEST_DIR/app/Validators"
touch "$DEST_DIR/app/Validators/.gitkeep"

# Repositories
rm -rf "$DEST_DIR/app/Repositories"
mkdir -p "$DEST_DIR/app/Repositories"
touch "$DEST_DIR/app/Repositories/.gitkeep"

# Jobs
rm -rf "$DEST_DIR/app/Jobs"
mkdir -p "$DEST_DIR/app/Jobs"
touch "$DEST_DIR/app/Jobs/.gitkeep"

# Notifications
rm -rf "$DEST_DIR/app/Notifications"
mkdir -p "$DEST_DIR/app/Notifications"
touch "$DEST_DIR/app/Notifications/.gitkeep"

# Console Commands
rm -rf "$DEST_DIR/app/Console/Commands"
mkdir -p "$DEST_DIR/app/Console/Commands"
touch "$DEST_DIR/app/Console/Commands/.gitkeep"

# Clean views - remove all, keep only layouts (empty), errors, welcome
# Save welcome.php and errors if they exist
cp "$DEST_DIR/resources/views/welcome.php" /tmp/welcome.php 2>/dev/null || true
cp -r "$DEST_DIR/resources/views/errors" /tmp/errors 2>/dev/null || true
if [ "$KEEP_DOCS" = true ]; then
    cp -r "$DEST_DIR/resources/views/docs" /tmp/docs 2>/dev/null || true
fi

rm -rf "$DEST_DIR/resources/views"
mkdir -p "$DEST_DIR/resources/views/layouts"
mkdir -p "$DEST_DIR/resources/views/errors"
touch "$DEST_DIR/resources/views/layouts/.gitkeep"

# Restore welcome.php and errors
cp /tmp/welcome.php "$DEST_DIR/resources/views/welcome.php" 2>/dev/null || true
cp -r /tmp/errors/* "$DEST_DIR/resources/views/errors/" 2>/dev/null || true
if [ "$KEEP_DOCS" = true ]; then
    cp -r /tmp/docs "$DEST_DIR/resources/views/" 2>/dev/null || true
fi
rm -f /tmp/welcome.php 2>/dev/null || true
rm -rf /tmp/errors 2>/dev/null || true
rm -rf /tmp/docs 2>/dev/null || true

# Clean routes - remove sub-route folders entirely
rm -rf "$DEST_DIR/routes/web"
rm -rf "$DEST_DIR/routes/api"
mkdir -p "$DEST_DIR/routes/web"
mkdir -p "$DEST_DIR/routes/api"
touch "$DEST_DIR/routes/web/.gitkeep"
touch "$DEST_DIR/routes/api/.gitkeep"

# Clean assets - remove all CSS/JS subfolders, keep only essential files
# Save essential files
cp "$DEST_DIR/public/assets/css/base.css" /tmp/base.css 2>/dev/null || true
cp "$DEST_DIR/public/assets/css/pages/welcome.css" /tmp/welcome.css 2>/dev/null || true
cp "$DEST_DIR/public/assets/js/theme.js" /tmp/theme.js 2>/dev/null || true
if [ "$KEEP_DOCS" = true ]; then
    cp -r "$DEST_DIR/public/assets/css/docs" /tmp/css-docs 2>/dev/null || true
    cp -r "$DEST_DIR/public/assets/js/docs" /tmp/js-docs 2>/dev/null || true
fi

rm -rf "$DEST_DIR/public/assets/css"
rm -rf "$DEST_DIR/public/assets/js"
mkdir -p "$DEST_DIR/public/assets/css/pages"
mkdir -p "$DEST_DIR/public/assets/js"

# Restore essential files
cp /tmp/base.css "$DEST_DIR/public/assets/css/base.css" 2>/dev/null || true
cp /tmp/welcome.css "$DEST_DIR/public/assets/css/pages/welcome.css" 2>/dev/null || true
cp /tmp/theme.js "$DEST_DIR/public/assets/js/theme.js" 2>/dev/null || true
if [ "$KEEP_DOCS" = true ]; then
    cp -r /tmp/css-docs "$DEST_DIR/public/assets/css/docs" 2>/dev/null || true
    cp -r /tmp/js-docs "$DEST_DIR/public/assets/js/docs" 2>/dev/null || true
fi
rm -f /tmp/base.css /tmp/welcome.css /tmp/theme.js 2>/dev/null || true
rm -rf /tmp/css-docs /tmp/js-docs 2>/dev/null || true

# Remove docs config (unless keeping docs)
if [ "$KEEP_DOCS" = false ]; then
    rm -f "$DEST_DIR/config/docs-navigation.php" 2>/dev/null || true
fi

echo -e "${GREEN}✓${NC} Demo files removed"

# Clean main route files - remove all require statements
echo -e "${BLUE}[4/10]${NC} Cleaning route files..."

# Clean web.php - remove all require statements for sub-routes
if [ -f "$DEST_DIR/routes/web.php" ]; then
    sed -i '/require.*\.php/d' "$DEST_DIR/routes/web.php" 2>/dev/null || true
fi

# Clean api.php - remove all require statements for sub-routes
if [ -f "$DEST_DIR/routes/api.php" ]; then
    sed -i '/require.*\.php/d' "$DEST_DIR/routes/api.php" 2>/dev/null || true
fi

echo -e "${GREEN}✓${NC} Route files cleaned"

# Clean database seeders - remove all and create empty folder
echo -e "${BLUE}[5/10]${NC} Cleaning database seeders..."

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
echo -e "${BLUE}[6/10]${NC} Creating storage directories..."
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
echo -e "${BLUE}[7/9]${NC} Setting permissions..."
chmod -R 755 "$DEST_DIR"
chmod -R 775 "$DEST_DIR/storage"

if [ -d "$DEST_DIR/bootstrap/cache" ]; then
    chmod -R 775 "$DEST_DIR/bootstrap/cache"
fi

echo -e "${GREEN}✓${NC} Permissions set"

# Create .env file
echo -e "${BLUE}[9/10]${NC} Creating environment file..."

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

# Create minimal README
echo -e "${BLUE}[10/10]${NC} Creating project README..."

PROJECT_NAME=$(basename "$DEST_DIR")

cat > "$DEST_DIR/README.md" << EOF
# $PROJECT_NAME

A PHP application built with the SO Framework.

## Quick Start

\`\`\`bash
# 1. Install dependencies
composer install

# 2. Configure environment
cp .env.example .env
# Edit .env with your database credentials

# 3. Set up database
mysql -u root -p < database/schema.sql

# 4. Set permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# 5. Configure web server to point to public/ directory
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
echo -e "  3. ${BLUE}Configure your .env file${NC}"
echo -e "  4. ${BLUE}Import database/schema.sql${NC}"
echo -e "  5. ${BLUE}Configure web server → public/${NC}"
echo ""
echo -e "${BLUE}Excluded from copy:${NC}"
echo -e "  • Documentation (docs/) $(if [ "$KEEP_DOCS" = true ]; then echo -e "${YELLOW}[KEPT]${NC}"; fi)"
echo -e "  • Tests (tests/)"
echo -e "  • Development notes (todo/)"
echo -e "  • Setup scripts (setup/)"
echo -e "  • Git history"
echo -e "  • node_modules/ and vendor/"
echo ""
echo -e "${BLUE}Cleaned (empty folders with .gitkeep):${NC}"
echo -e "  • app/Controllers/Auth/, app/Controllers/User/"
echo -e "  • app/Services/Auth/, app/Services/User/"
echo -e "  • app/Validation/, app/Models/"
echo -e "  • database/migrations/, database/seeders/"
echo -e "  • routes/web/, routes/api/"
echo -e "  • resources/views/auth/, resources/views/dashboard/"
echo -e "  • Demo controllers, assets, and views"
echo ""
echo -e "${GREEN}Your clean framework is ready at:${NC}"
echo -e "${GREEN}$DEST_DIR${NC}"
echo ""
echo -e "${YELLOW}Pro tip:${NC} Use ${BLUE}--keep-docs${NC} flag to include framework documentation"
echo ""
