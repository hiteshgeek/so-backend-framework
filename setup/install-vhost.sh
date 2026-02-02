#!/bin/bash
#
# Virtual Host Setup Script
# Sets up Apache virtual host and configures the application
#

set -e

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

SETUP_DIR="$(cd "$(dirname "$0")" && pwd)"
PROJECT_DIR="$(cd "${SETUP_DIR}/.." && pwd)"
PUBLIC_DIR="${PROJECT_DIR}/public"
PROJECT_NAME="$(basename "$PROJECT_DIR")"

# Default domain derived from project name
DEFAULT_DOMAIN="${PROJECT_NAME}.local"

# Parse arguments
DOMAIN="${1:-$DEFAULT_DOMAIN}"
CONF_FILE="${DOMAIN}.conf"

echo ""
echo -e "${BLUE}╔════════════════════════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║         Apache Virtual Host Setup                          ║${NC}"
echo -e "${BLUE}╚════════════════════════════════════════════════════════════╝${NC}"
echo ""
echo -e "${YELLOW}Project:${NC}     $PROJECT_NAME"
echo -e "${YELLOW}Domain:${NC}      $DOMAIN"
echo -e "${YELLOW}DocumentRoot:${NC} $PUBLIC_DIR"
echo ""

# Check if running as root
if [ "$EUID" -ne 0 ]; then
    echo -e "${RED}Error: Please run as root (sudo bash $0 [domain])${NC}"
    echo ""
    echo "Usage:"
    echo "  sudo bash setup/install-vhost.sh              # Uses ${DEFAULT_DOMAIN}"
    echo "  sudo bash setup/install-vhost.sh myapp.local  # Custom domain"
    exit 1
fi

# Check Apache is installed
if ! command -v apache2 &> /dev/null; then
    echo -e "${RED}Error: Apache2 is not installed${NC}"
    exit 1
fi

# Step 1: Generate vhost config dynamically
echo -e "${YELLOW}[1/6]${NC} Generating virtual host config..."
cat > /etc/apache2/sites-available/${CONF_FILE} << EOF
<VirtualHost *:80>
    ServerName ${DOMAIN}
    ServerAlias www.${DOMAIN}

    DocumentRoot ${PUBLIC_DIR}

    <Directory ${PUBLIC_DIR}>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    # Logging
    ErrorLog \${APACHE_LOG_DIR}/${DOMAIN}-error.log
    CustomLog \${APACHE_LOG_DIR}/${DOMAIN}-access.log combined

    # PHP settings
    <FilesMatch \.php$>
        SetHandler application/x-httpd-php
    </FilesMatch>
</VirtualHost>
EOF
echo -e "${GREEN}✓${NC} Generated /etc/apache2/sites-available/${CONF_FILE}"

# Step 2: Enable the site
echo -e "${YELLOW}[2/6]${NC} Enabling site..."
a2ensite ${CONF_FILE} > /dev/null 2>&1 || true
echo -e "${GREEN}✓${NC} Site enabled"

# Step 3: Enable required Apache modules
echo -e "${YELLOW}[3/6]${NC} Enabling Apache modules..."
a2enmod rewrite > /dev/null 2>&1 || true
a2enmod headers > /dev/null 2>&1 || true
echo -e "${GREEN}✓${NC} Modules: rewrite, headers enabled"

# Step 4: Add to /etc/hosts if not already there
echo -e "${YELLOW}[4/6]${NC} Updating /etc/hosts..."
if grep -q "${DOMAIN}" /etc/hosts; then
    echo -e "${GREEN}✓${NC} ${DOMAIN} already in /etc/hosts"
else
    echo "127.0.0.1   ${DOMAIN} www.${DOMAIN}" >> /etc/hosts
    echo -e "${GREEN}✓${NC} Added ${DOMAIN} to /etc/hosts"
fi

# Step 5: Set permissions
echo -e "${YELLOW}[5/6]${NC} Setting permissions..."
chown -R www-data:www-data "${PROJECT_DIR}/storage"
chmod -R 775 "${PROJECT_DIR}/storage"
if [ -d "${PROJECT_DIR}/bootstrap/cache" ]; then
    chown -R www-data:www-data "${PROJECT_DIR}/bootstrap/cache"
    chmod -R 775 "${PROJECT_DIR}/bootstrap/cache"
fi
echo -e "${GREEN}✓${NC} Permissions set on storage/ and bootstrap/cache/"

# Step 6: Test config and restart Apache
echo -e "${YELLOW}[6/6]${NC} Restarting Apache..."
if apache2ctl configtest 2>&1 | grep -q "Syntax OK"; then
    systemctl restart apache2
    echo -e "${GREEN}✓${NC} Apache restarted successfully"
else
    echo -e "${RED}✗ Apache config test failed:${NC}"
    apache2ctl configtest
    exit 1
fi

# Update .env APP_URL if file exists
if [ -f "${PROJECT_DIR}/.env" ]; then
    echo ""
    echo -e "${YELLOW}Updating .env...${NC}"
    sed -i "s|APP_URL=.*|APP_URL=http://${DOMAIN}|" "${PROJECT_DIR}/.env"
    echo -e "${GREEN}✓${NC} APP_URL set to http://${DOMAIN}"
fi

# Summary
echo ""
echo -e "${GREEN}╔════════════════════════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║         Setup Complete!                                    ║${NC}"
echo -e "${GREEN}╚════════════════════════════════════════════════════════════╝${NC}"
echo ""
echo "  Domain:       http://${DOMAIN}"
echo "  DocumentRoot: ${PUBLIC_DIR}"
echo "  Config:       /etc/apache2/sites-available/${CONF_FILE}"
echo ""
echo "  Test it:"
echo "    curl http://${DOMAIN}"
echo "    Open http://${DOMAIN} in your browser"
echo ""
echo "  To remove this virtual host:"
echo "    sudo bash setup/cleanup-vhost.sh ${DOMAIN}"
echo ""
