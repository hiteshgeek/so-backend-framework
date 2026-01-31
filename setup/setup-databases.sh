#!/bin/bash

# ============================================
# SO Framework - Dual Database Setup Script
# ============================================
# This script automates the creation and setup of both databases
# Usage: bash setup/setup-databases.sh
# ============================================

echo "================================================"
echo "  SO Framework - Dual Database Setup"
echo "================================================"
echo ""

# Get database credentials
read -p "MySQL Username [root]: " DB_USER
DB_USER=${DB_USER:-root}

read -sp "MySQL Password: " DB_PASS
echo ""

read -p "Application Database Name [so_framework]: " APP_DB
APP_DB=${APP_DB:-so_framework}

ESSENTIALS_DB="so_essentials"

echo ""
echo "Configuration:"
echo "  Username: $DB_USER"
echo "  Application DB: $APP_DB"
echo "  Essentials DB: $ESSENTIALS_DB"
echo ""

read -p "Continue with setup? (y/n): " CONFIRM
if [ "$CONFIRM" != "y" ]; then
    echo "Setup cancelled."
    exit 0
fi

echo ""
echo "Step 1: Creating databases..."
echo "-----------------------------------"

# Create essentials database
echo "Creating $ESSENTIALS_DB database..."
mysql -u "$DB_USER" -p"$DB_PASS" -e "CREATE DATABASE IF NOT EXISTS $ESSENTIALS_DB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>/dev/null
if [ $? -eq 0 ]; then
    echo "✓ Essentials database created successfully"
else
    echo "✗ Failed to create essentials database"
    exit 1
fi

# Create application database
echo "Creating $APP_DB database..."
mysql -u "$DB_USER" -p"$DB_PASS" -e "CREATE DATABASE IF NOT EXISTS $APP_DB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>/dev/null
if [ $? -eq 0 ]; then
    echo "✓ Application database created successfully"
else
    echo "✗ Failed to create application database"
    exit 1
fi

echo ""
echo "Step 2: Running migrations..."
echo "-----------------------------------"

# Migrate essentials database
echo "Migrating framework essentials..."
mysql -u "$DB_USER" -p"$DB_PASS" "$ESSENTIALS_DB" < database/migrations/001_framework_essentials.sql 2>/dev/null
if [ $? -eq 0 ]; then
    echo "✓ Essentials migration completed"
else
    echo "✗ Essentials migration failed"
    exit 1
fi

# Migrate application database
read -p "Install demo tables in application database? (y/n): " DEMO
if [ "$DEMO" = "y" ]; then
    echo "Installing demo tables..."
    mysql -u "$DB_USER" -p"$DB_PASS" "$APP_DB" < database/migrations/002_demo_tables.sql 2>/dev/null
    if [ $? -eq 0 ]; then
        echo "✓ Demo tables installed"
    else
        echo "✗ Demo tables installation failed"
        exit 1
    fi
fi

echo ""
echo "Step 3: Updating .env file..."
echo "-----------------------------------"

# Backup existing .env if it exists
if [ -f .env ]; then
    cp .env .env.backup
    echo "✓ Backed up existing .env to .env.backup"
fi

# Create/update .env file
if [ ! -f .env ]; then
    cp .env.example .env
    echo "✓ Created .env from .env.example"
fi

# Update database settings in .env
sed -i "s/DB_DATABASE=.*/DB_DATABASE=$APP_DB/" .env
sed -i "s/DB_USERNAME=.*/DB_USERNAME=$DB_USER/" .env
sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=$DB_PASS/" .env

sed -i "s/DB_ESSENTIALS_DATABASE=.*/DB_ESSENTIALS_DATABASE=$ESSENTIALS_DB/" .env
sed -i "s/DB_ESSENTIALS_USERNAME=.*/DB_ESSENTIALS_USERNAME=$DB_USER/" .env
sed -i "s/DB_ESSENTIALS_PASSWORD=.*/DB_ESSENTIALS_PASSWORD=$DB_PASS/" .env

echo "✓ Updated .env with database credentials"

echo ""
echo "Step 4: Verifying setup..."
echo "-----------------------------------"

# Test essentials database
ESSENTIALS_TABLES=$(mysql -u "$DB_USER" -p"$DB_PASS" "$ESSENTIALS_DB" -e "SHOW TABLES;" 2>/dev/null | wc -l)
echo "✓ Essentials database: $((ESSENTIALS_TABLES-1)) tables created"

# Test application database
APP_TABLES=$(mysql -u "$DB_USER" -p"$DB_PASS" "$APP_DB" -e "SHOW TABLES;" 2>/dev/null | wc -l)
echo "✓ Application database: $((APP_TABLES-1)) tables created"

echo ""
echo "================================================"
echo "  Setup Complete!"
echo "================================================"
echo ""
echo "Database Summary:"
echo "  • Essentials DB: $ESSENTIALS_DB ($((ESSENTIALS_TABLES-1)) tables)"
echo "  • Application DB: $APP_DB ($((APP_TABLES-1)) tables)"
echo ""
echo "Next Steps:"
echo "  1. Review your .env file"
echo "  2. Set APP_KEY: php sixorbit key:generate"
echo "  3. Start development: php -S localhost:8000 -t public"
echo ""
echo "Documentation:"
echo "  • See database/migrations/README.md for detailed usage"
echo "  • Essential tables list in 001_framework_essentials.sql"
echo "  • Demo tables list in 002_demo_tables.sql"
echo ""
echo "================================================"
