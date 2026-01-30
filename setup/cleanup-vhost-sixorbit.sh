#!/bin/bash
#
# Cleanup Script - Remove sixorbit.be.local Virtual Host
# Removes Apache config, disables site, and cleans up /etc/hosts
#

set -e

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

DOMAIN="sixorbit.be.local"
CONF_FILE="sixorbit.be.local.conf"

echo ""
echo "========================================="
echo "  Cleanup: ${DOMAIN}"
echo "========================================="
echo ""

# Check if running as root
if [ "$EUID" -ne 0 ]; then
    echo -e "${RED}Error: Please run as root (sudo bash $0)${NC}"
    exit 1
fi

# Step 1: Disable the site
echo -e "${YELLOW}[1/4] Disabling site...${NC}"
if [ -L "/etc/apache2/sites-enabled/${CONF_FILE}" ]; then
    a2dissite ${CONF_FILE} > /dev/null 2>&1 || true
    echo -e "${GREEN}      Site disabled${NC}"
else
    echo -e "${GREEN}      Site not enabled (skipped)${NC}"
fi

# Step 2: Remove config file
echo -e "${YELLOW}[2/4] Removing config file...${NC}"
if [ -f "/etc/apache2/sites-available/${CONF_FILE}" ]; then
    rm -f /etc/apache2/sites-available/${CONF_FILE}
    echo -e "${GREEN}      Removed /etc/apache2/sites-available/${CONF_FILE}${NC}"
else
    echo -e "${GREEN}      Config file not found (skipped)${NC}"
fi

# Step 3: Remove from /etc/hosts
echo -e "${YELLOW}[3/4] Cleaning /etc/hosts...${NC}"
if grep -q "${DOMAIN}" /etc/hosts; then
    sed -i "/${DOMAIN}/d" /etc/hosts
    echo -e "${GREEN}      Removed ${DOMAIN} from /etc/hosts${NC}"
else
    echo -e "${GREEN}      ${DOMAIN} not in /etc/hosts (skipped)${NC}"
fi

# Step 4: Reload Apache
echo -e "${YELLOW}[4/4] Reloading Apache...${NC}"
if systemctl reload apache2; then
    echo -e "${GREEN}      Apache reloaded${NC}"
else
    echo -e "${RED}      Apache reload failed${NC}"
    exit 1
fi

# Summary
echo ""
echo "========================================="
echo -e "${GREEN}  Cleanup Complete!${NC}"
echo "========================================="
echo ""
echo "Removed:"
echo "  ✓ Virtual host config"
echo "  ✓ Sites-enabled symlink"
echo "  ✓ /etc/hosts entry"
echo ""
echo "You can now test the installation script:"
echo "  sudo bash setup/install-vhost-sixorbit.sh"
echo ""
echo "========================================="
