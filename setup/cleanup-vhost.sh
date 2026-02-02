#!/bin/bash
#
# Cleanup Script - Remove Virtual Host
# Removes Apache config, disables site, and cleans up /etc/hosts
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
PROJECT_NAME="$(basename "$PROJECT_DIR")"

# Default domain derived from project name
DEFAULT_DOMAIN="${PROJECT_NAME}.local"

# Parse arguments
DOMAIN="${1:-$DEFAULT_DOMAIN}"
CONF_FILE="${DOMAIN}.conf"

echo ""
echo -e "${BLUE}╔════════════════════════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║         Cleanup Virtual Host                               ║${NC}"
echo -e "${BLUE}╚════════════════════════════════════════════════════════════╝${NC}"
echo ""
echo -e "${YELLOW}Domain:${NC} $DOMAIN"
echo ""

# Check if running as root
if [ "$EUID" -ne 0 ]; then
    echo -e "${RED}Error: Please run as root (sudo bash $0 [domain])${NC}"
    echo ""
    echo "Usage:"
    echo "  sudo bash setup/cleanup-vhost.sh              # Removes ${DEFAULT_DOMAIN}"
    echo "  sudo bash setup/cleanup-vhost.sh myapp.local  # Custom domain"
    exit 1
fi

# Step 1: Disable the site
echo -e "${YELLOW}[1/4]${NC} Disabling site..."
if [ -L "/etc/apache2/sites-enabled/${CONF_FILE}" ]; then
    a2dissite ${CONF_FILE} > /dev/null 2>&1 || true
    echo -e "${GREEN}✓${NC} Site disabled"
else
    echo -e "${GREEN}✓${NC} Site not enabled (skipped)"
fi

# Step 2: Remove config file
echo -e "${YELLOW}[2/4]${NC} Removing config file..."
if [ -f "/etc/apache2/sites-available/${CONF_FILE}" ]; then
    rm -f /etc/apache2/sites-available/${CONF_FILE}
    echo -e "${GREEN}✓${NC} Removed /etc/apache2/sites-available/${CONF_FILE}"
else
    echo -e "${GREEN}✓${NC} Config file not found (skipped)"
fi

# Step 3: Remove from /etc/hosts
echo -e "${YELLOW}[3/4]${NC} Cleaning /etc/hosts..."
if grep -q "${DOMAIN}" /etc/hosts; then
    sed -i "/${DOMAIN}/d" /etc/hosts
    echo -e "${GREEN}✓${NC} Removed ${DOMAIN} from /etc/hosts"
else
    echo -e "${GREEN}✓${NC} ${DOMAIN} not in /etc/hosts (skipped)"
fi

# Step 4: Reload Apache
echo -e "${YELLOW}[4/4]${NC} Reloading Apache..."
if systemctl reload apache2; then
    echo -e "${GREEN}✓${NC} Apache reloaded"
else
    echo -e "${RED}✗ Apache reload failed${NC}"
    exit 1
fi

# Summary
echo ""
echo -e "${GREEN}╔════════════════════════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║         Cleanup Complete!                                  ║${NC}"
echo -e "${GREEN}╚════════════════════════════════════════════════════════════╝${NC}"
echo ""
echo "Removed:"
echo "  ✓ Virtual host config (/etc/apache2/sites-available/${CONF_FILE})"
echo "  ✓ Sites-enabled symlink"
echo "  ✓ /etc/hosts entry"
echo ""
echo "To reinstall:"
echo "  sudo bash setup/install-vhost.sh ${DOMAIN}"
echo ""
