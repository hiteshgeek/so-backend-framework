# SixOrbit Framework Setup Guide

## Prerequisites

- Apache 2.4+
- PHP 8.0+
- MySQL 5.7+ or MariaDB 10.3+
- Composer

## Installation Steps

### 1. Clone the Repository

```bash
git clone <repository-url> /var/www/html/so-backend-framework
cd /var/www/html/so-backend-framework
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Configuration

Copy the example environment file and configure it:

```bash
cp .env.example .env
```

Update the following values in `.env`:

```env
APP_URL=http://sixorbit.local
DB_DATABASE=so-framework
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Apache Virtual Host Setup

#### Copy the virtual host configuration:

```bash
sudo cp sixorbit.local.conf /etc/apache2/sites-available/
```

#### Enable the site and required modules:

```bash
sudo a2ensite sixorbit.local.conf
sudo a2enmod rewrite
sudo a2enmod headers
sudo systemctl reload apache2
```

### 5. Hosts File Configuration

Add the following entries to your hosts file:

#### Windows (C:\Windows\System32\drivers\etc\hosts)

Open Notepad as Administrator, then open the hosts file and add:

```
127.0.0.1    sixorbit.local
127.0.0.1    www.sixorbit.local
```

#### Linux/Mac (/etc/hosts)

```bash
sudo nano /etc/hosts
```

Add:

```
127.0.0.1    sixorbit.local
127.0.0.1    www.sixorbit.local
```

### 6. Directory Permissions

Set proper permissions for storage and cache directories:

```bash
sudo chown -R www-data:www-data /var/www/html/so-backend-framework
sudo chmod -R 755 /var/www/html/so-backend-framework
sudo chmod -R 775 /var/www/html/so-backend-framework/storage
sudo chmod -R 775 /var/www/html/so-backend-framework/bootstrap/cache
```

### 7. Database Setup

Create the database:

```bash
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS \`so-framework\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

Run migrations:

```bash
php artisan migrate
```

### 8. Generate Application Key

```bash
php artisan key:generate
```

### 9. Verify Installation

Open your browser and navigate to:

```
http://sixorbit.local
```

## Troubleshooting

### Apache not starting

Check Apache error logs:

```bash
sudo tail -f /var/log/apache2/error.log
```

### Permission denied errors

Ensure proper ownership:

```bash
sudo chown -R www-data:www-data /var/www/html/so-backend-framework
```

### Site not loading

1. Verify Apache is running: `sudo systemctl status apache2`
2. Check if the site is enabled: `sudo a2query -s sixorbit.local`
3. Verify hosts file entry is correct
4. Clear browser cache

### Database connection errors

1. Verify MySQL is running: `sudo systemctl status mysql`
2. Check credentials in `.env` file
3. Ensure database exists: `mysql -u root -p -e "SHOW DATABASES;"`

## Quick Setup Script

For a quick setup, run:

```bash
#!/bin/bash

# Copy virtual host config
sudo cp sixorbit.local.conf /etc/apache2/sites-available/

# Enable site and modules
sudo a2ensite sixorbit.local.conf
sudo a2enmod rewrite headers

# Set permissions
sudo chown -R www-data:www-data /var/www/html/so-backend-framework
sudo chmod -R 775 storage bootstrap/cache

# Reload Apache
sudo systemctl reload apache2

echo "Setup complete! Add '127.0.0.1 sixorbit.local' to your hosts file."
```

Save this as `setup.sh` and run with `bash setup.sh`.
