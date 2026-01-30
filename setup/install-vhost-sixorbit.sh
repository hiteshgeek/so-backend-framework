#!/bin/bash
#
# Virtual Host Setup Script - Sixorbit.be.local
# Sets up Apache virtual host and configures the application
#

set -e

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

DOMAIN="sixorbit.be.local"
CONF_FILE="sixorbit.be.local.conf"
SETUP_DIR="$(cd "$(dirname "$0")" && pwd)"
PROJECT_DIR="$(cd "${SETUP_DIR}/.." && pwd)"
PUBLIC_DIR="${PROJECT_DIR}/public"

echo ""
echo "========================================="
echo "  Sixorbit.be.local - VHost Setup"
echo "========================================="
echo ""

# Check if running as root
if [ "$EUID" -ne 0 ]; then
    echo -e "${RED}Error: Please run as root (sudo bash $0)${NC}"
    exit 1
fi

# Check Apache is installed
if ! command -v apache2 &> /dev/null; then
    echo -e "${RED}Error: Apache2 is not installed${NC}"
    exit 1
fi

# Step 1: Generate vhost config dynamically
echo -e "${YELLOW}[1/6] Generating virtual host config...${NC}"
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
echo -e "${GREEN}      Generated /etc/apache2/sites-available/${CONF_FILE}${NC}"
echo -e "${GREEN}      DocumentRoot: ${PUBLIC_DIR}${NC}"

# Step 2: Enable the site
echo -e "${YELLOW}[2/6] Enabling site...${NC}"
a2ensite ${CONF_FILE} > /dev/null 2>&1 || true
echo -e "${GREEN}      Site enabled${NC}"

# Step 3: Enable required Apache modules
echo -e "${YELLOW}[3/6] Enabling Apache modules...${NC}"
a2enmod rewrite > /dev/null 2>&1 || true
a2enmod headers > /dev/null 2>&1 || true
echo -e "${GREEN}      Modules: rewrite, headers enabled${NC}"

# Step 4: Add to /etc/hosts if not already there
echo -e "${YELLOW}[4/6] Updating /etc/hosts...${NC}"
if grep -q "${DOMAIN}" /etc/hosts; then
    echo -e "${GREEN}      ${DOMAIN} already in /etc/hosts${NC}"
else
    echo "127.0.0.1   ${DOMAIN} www.${DOMAIN}" >> /etc/hosts
    echo -e "${GREEN}      Added ${DOMAIN} to /etc/hosts${NC}"
fi

# Step 5: Set permissions
echo -e "${YELLOW}[5/6] Setting permissions...${NC}"
chown -R www-data:www-data "${PROJECT_DIR}/storage"
chmod -R 775 "${PROJECT_DIR}/storage"
if [ -d "${PROJECT_DIR}/bootstrap/cache" ]; then
    chown -R www-data:www-data "${PROJECT_DIR}/bootstrap/cache"
    chmod -R 775 "${PROJECT_DIR}/bootstrap/cache"
fi
echo -e "${GREEN}      Permissions set on storage/ and bootstrap/cache/${NC}"

# Step 6: Test config and restart Apache
echo -e "${YELLOW}[6/6] Restarting Apache...${NC}"
if apache2ctl configtest 2>&1 | grep -q "Syntax OK"; then
    systemctl restart apache2
    echo -e "${GREEN}      Apache restarted successfully${NC}"
else
    echo -e "${RED}      Apache config test failed:${NC}"
    apache2ctl configtest
    exit 1
fi

# Update .env APP_URL
echo ""
echo -e "${YELLOW}Updating .env...${NC}"
sed -i "s|APP_URL=.*|APP_URL=http://${DOMAIN}|" "${PROJECT_DIR}/.env"
echo -e "${GREEN}      APP_URL set to http://${DOMAIN}${NC}"

# Summary
echo ""
echo "========================================="
echo -e "${GREEN}  Setup Complete!${NC}"
echo "========================================="
echo ""
echo "  Domain:       http://${DOMAIN}"
echo "  DocumentRoot: ${PUBLIC_DIR}"
echo "  Config:       /etc/apache2/sites-available/${CONF_FILE}"
echo ""
echo "  Test it:"
echo "    curl http://${DOMAIN}"
echo "    curl http://${DOMAIN}/api/test"
echo ""
echo "  Note: The root .htaccess is no longer needed"
echo "  when using the virtual host. Only public/.htaccess"
echo "  is active since DocumentRoot points to public/."
echo ""
echo "========================================="
