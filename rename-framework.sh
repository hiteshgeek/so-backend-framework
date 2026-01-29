#!/bin/bash

# ============================================
# Framework Rename Script
# ============================================
# Automatically renames the framework throughout all files
#
# Usage: ./rename-framework.sh "Framework Name" "database-name" "vendor/package"
#
# Example:
#   ./rename-framework.sh "My Framework" "my-framework" "mycompany/framework"
# ============================================

NEW_NAME="$1"           # Display name (e.g., "My Framework")
NEW_DB="$2"             # Database name (e.g., "my-framework")
NEW_PACKAGE="$3"        # Package name (e.g., "vendor/framework")

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Validate input
if [ -z "$NEW_NAME" ] || [ -z "$NEW_DB" ]; then
    echo -e "${RED}Error: Missing required arguments${NC}"
    echo ""
    echo "Usage: ./rename-framework.sh 'Framework Name' 'database-name' 'vendor/package'"
    echo ""
    echo "Example:"
    echo "  ./rename-framework.sh 'My Framework' 'my-framework' 'mycompany/framework'"
    echo ""
    exit 1
fi

echo ""
echo "🔄 Framework Rename Tool"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo -e "  ${GREEN}Display Name:${NC} $NEW_NAME"
echo -e "  ${GREEN}Database:${NC}     $NEW_DB"
if [ -n "$NEW_PACKAGE" ]; then
    echo -e "  ${GREEN}Package:${NC}      $NEW_PACKAGE"
fi
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

# Confirmation
read -p "Continue with rename? (y/n) " -n 1 -r
echo ""
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo -e "${YELLOW}Cancelled.${NC}"
    exit 0
fi

echo ""

# Backup current state
echo -e "${YELLOW}📦 Creating backup...${NC}"
BACKUP_DIR="backups/rename-$(date +%Y%m%d-%H%M%S)"
mkdir -p "$BACKUP_DIR"
cp .env "$BACKUP_DIR/.env.backup" 2>/dev/null
cp .env.example "$BACKUP_DIR/.env.example.backup" 2>/dev/null
cp composer.json "$BACKUP_DIR/composer.json.backup" 2>/dev/null
echo -e "${GREEN}   ✓ Backup created: $BACKUP_DIR${NC}"
echo ""

# Update .env
echo -e "${YELLOW}✏️  Updating .env...${NC}"
if [ -f .env ]; then
    sed -i.bak "s/APP_NAME=\".*\"/APP_NAME=\"$NEW_NAME\"/" .env
    sed -i.bak "s/DB_DATABASE=.*/DB_DATABASE=$NEW_DB/" .env
    rm .env.bak 2>/dev/null
    echo -e "${GREEN}   ✓ .env updated${NC}"
else
    echo -e "${RED}   ✗ .env not found${NC}"
fi

# Update .env.example
echo -e "${YELLOW}✏️  Updating .env.example...${NC}"
if [ -f .env.example ]; then
    sed -i.bak "s/APP_NAME=\".*\"/APP_NAME=\"$NEW_NAME\"/" .env.example
    sed -i.bak "s/DB_DATABASE=.*/DB_DATABASE=$NEW_DB/" .env.example
    rm .env.example.bak 2>/dev/null
    echo -e "${GREEN}   ✓ .env.example updated${NC}"
else
    echo -e "${RED}   ✗ .env.example not found${NC}"
fi

# Update composer.json
if [ -n "$NEW_PACKAGE" ]; then
    echo -e "${YELLOW}✏️  Updating composer.json...${NC}"
    if [ -f composer.json ]; then
        sed -i.bak "s/\"name\": \".*\"/\"name\": \"$NEW_PACKAGE\"/" composer.json
        rm composer.json.bak 2>/dev/null
        echo -e "${GREEN}   ✓ composer.json updated${NC}"
    else
        echo -e "${RED}   ✗ composer.json not found${NC}"
    fi
fi

# Regenerate SQL
echo -e "${YELLOW}🔨 Regenerating database setup...${NC}"
if [ -f database/migrations/generate-setup.php ]; then
    php database/migrations/generate-setup.php
    echo -e "${GREEN}   ✓ setup.sql regenerated${NC}"
else
    echo -e "${RED}   ✗ generate-setup.php not found${NC}"
fi

# Update documentation
echo -e "${YELLOW}📝 Updating documentation...${NC}"
DOC_COUNT=0
if [ -f README.md ]; then
    sed -i.bak "s/SO Framework/$NEW_NAME/g" README.md
    sed -i.bak "s/so-framework/$NEW_DB/g" README.md
    rm README.md.bak 2>/dev/null
    DOC_COUNT=$((DOC_COUNT + 1))
fi

if [ -f SETUP.md ]; then
    sed -i.bak "s/SO Framework/$NEW_NAME/g" SETUP.md
    sed -i.bak "s/so-framework/$NEW_DB/g" SETUP.md
    rm SETUP.md.bak 2>/dev/null
    DOC_COUNT=$((DOC_COUNT + 1))
fi

if [ -f CONFIGURATION.md ]; then
    sed -i.bak "s/SO Framework/$NEW_NAME/g" CONFIGURATION.md
    sed -i.bak "s/so-framework/$NEW_DB/g" CONFIGURATION.md
    rm CONFIGURATION.md.bak 2>/dev/null
    DOC_COUNT=$((DOC_COUNT + 1))
fi

if [ -f QUICK-START.md ]; then
    sed -i.bak "s/SO Framework/$NEW_NAME/g" QUICK-START.md
    sed -i.bak "s/so-framework/$NEW_DB/g" QUICK-START.md
    rm QUICK-START.md.bak 2>/dev/null
    DOC_COUNT=$((DOC_COUNT + 1))
fi

echo -e "${GREEN}   ✓ $DOC_COUNT documentation files updated${NC}"

# Dump autoload
echo -e "${YELLOW}🔄 Updating autoloader...${NC}"
if command -v composer &> /dev/null; then
    composer dump-autoload -q
    echo -e "${GREEN}   ✓ Autoloader updated${NC}"
else
    echo -e "${YELLOW}   ⚠ Composer not found, skipping${NC}"
fi

echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo -e "${GREEN}✅ Framework renamed successfully!${NC}"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""
echo "📋 Next steps:"
echo ""
echo "  1. Review changes:"
echo "     git diff"
echo ""
echo "  2. Import database:"
echo "     mysql -u root -p < database/migrations/setup.sql"
echo ""
echo "  3. Test the framework:"
echo "     curl http://localhost:8000"
echo "     curl http://localhost:8000/api/test"
echo ""
echo "  4. If everything works, commit:"
echo "     git add ."
echo "     git commit -m 'Rebrand to $NEW_NAME'"
echo ""
echo "💾 Backup location: $BACKUP_DIR"
echo ""
