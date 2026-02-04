#!/bin/bash

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Get script directory (framework root)
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
SOURCE_DIR="$(dirname "$SCRIPT_DIR")"

# Validate source directory
if [ ! -f "$SOURCE_DIR/core/Application.php" ]; then
    echo -e "${RED}Error: Not a valid framework directory (core/Application.php not found)${NC}"
    exit 1
fi

# Parse arguments
DEST_DIR=""

for arg in "$@"; do
    if [ -z "$DEST_DIR" ]; then
        DEST_DIR="$arg"
    fi
done

# Check if destination path provided
if [ -z "$DEST_DIR" ]; then
    echo -e "${RED}Error: Destination project path required${NC}"
    echo ""
    echo "Usage:"
    echo "  ./setup/update-project.sh /path/to/existing-project"
    echo ""
    echo "Examples:"
    echo "  ./setup/update-project.sh /var/www/html/my-app"
    echo "  ./setup/update-project.sh ../my-existing-project"
    exit 1
fi

# Check if destination exists
if [ ! -d "$DEST_DIR" ]; then
    echo -e "${RED}Error: Destination project does not exist: $DEST_DIR${NC}"
    echo -e "${YELLOW}Use create-project.sh to create a new project${NC}"
    exit 1
fi

# Validate destination is a framework project
if [ ! -f "$DEST_DIR/core/Application.php" ]; then
    echo -e "${RED}Error: Not a valid framework project (core/Application.php not found)${NC}"
    exit 1
fi

echo -e "${BLUE}╔════════════════════════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║         Framework Project Updater                          ║${NC}"
echo -e "${BLUE}╚════════════════════════════════════════════════════════════╝${NC}"
echo ""
echo -e "${YELLOW}Source:${NC}      $SOURCE_DIR"
echo -e "${YELLOW}Project:${NC}     $DEST_DIR"
echo ""

# Create backup timestamp
BACKUP_TIMESTAMP=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="$DEST_DIR/.framework-backups/update-$BACKUP_TIMESTAMP"

echo -e "${BLUE}[1/4]${NC} Creating backup..."
mkdir -p "$BACKUP_DIR/core"
mkdir -p "$BACKUP_DIR/bootstrap"

# Backup existing core files
if [ -d "$DEST_DIR/core" ]; then
    cp -r "$DEST_DIR/core" "$BACKUP_DIR/" 2>/dev/null || true
fi

if [ -f "$DEST_DIR/bootstrap/app.php" ]; then
    cp -r "$DEST_DIR/bootstrap" "$BACKUP_DIR/" 2>/dev/null || true
fi

if [ -f "$DEST_DIR/.env.example" ]; then
    cp "$DEST_DIR/.env.example" "$BACKUP_DIR/" 2>/dev/null || true
fi

if [ -f "$DEST_DIR/composer.json" ]; then
    cp "$DEST_DIR/composer.json" "$BACKUP_DIR/" 2>/dev/null || true
fi

echo -e "${GREEN}✓${NC} Backup created at: .framework-backups/update-$BACKUP_TIMESTAMP"

# Update core framework
echo -e "${BLUE}[2/4]${NC} Updating core framework..."
rsync -a --quiet "$SOURCE_DIR/core/" "$DEST_DIR/core/"
echo -e "${GREEN}✓${NC} Core framework updated"

# Update bootstrap
echo -e "${BLUE}[3/4]${NC} Updating bootstrap..."
cp "$SOURCE_DIR/bootstrap/app.php" "$DEST_DIR/bootstrap/app.php"
echo -e "${GREEN}✓${NC} Bootstrap updated"

# Update environment template and dependencies
echo -e "${BLUE}[4/4]${NC} Updating templates and dependencies..."

if [ -f "$SOURCE_DIR/.env.example" ]; then
    cp "$SOURCE_DIR/.env.example" "$DEST_DIR/.env.example"
    echo -e "${GREEN}✓${NC} .env.example updated"
fi

if [ -f "$SOURCE_DIR/composer.json" ]; then
    cp "$SOURCE_DIR/composer.json" "$DEST_DIR/composer.json"
    echo -e "${GREEN}✓${NC} composer.json updated"
fi

echo ""
echo -e "${GREEN}╔════════════════════════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║               Update Completed Successfully                ║${NC}"
echo -e "${GREEN}╚════════════════════════════════════════════════════════════╝${NC}"
echo ""
echo -e "${BLUE}Updated Components:${NC}"
echo -e "  ✓ Core framework (core/)"
echo -e "  ✓ Application bootstrap (bootstrap/app.php)"
echo -e "  ✓ Environment template (.env.example)"
echo -e "  ✓ Composer dependencies (composer.json)"
echo ""
echo -e "${YELLOW}Next Steps:${NC}"
echo -e "  1. Review .env.example for new configuration options"
echo -e "  2. Update your .env file if needed"
echo -e "  3. Run: ${BLUE}composer update${NC} to update dependencies"
echo -e "  4. Test your application thoroughly"
echo ""
echo -e "${YELLOW}Backup Location:${NC}"
echo -e "  $DEST_DIR/.framework-backups/update-$BACKUP_TIMESTAMP"
echo ""
echo -e "${YELLOW}To rollback (if needed):${NC}"
echo -e "  cp -r $DEST_DIR/.framework-backups/update-$BACKUP_TIMESTAMP/core $DEST_DIR/"
echo -e "  cp $DEST_DIR/.framework-backups/update-$BACKUP_TIMESTAMP/bootstrap/app.php $DEST_DIR/bootstrap/"
echo ""
