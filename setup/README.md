# Setup Scripts

Scripts for setting up and deploying the framework.

## create-project.sh

Creates a clean copy of the framework for starting a new project.

### Usage

```bash
# Basic usage
./setup/create-project.sh /path/to/new-project

# Keep documentation
./setup/create-project.sh /path/to/new-project --keep-docs
```

### Examples

```bash
# Create new project in /var/www/html/my-app
./setup/create-project.sh /var/www/html/my-app

# Create in parent directory
./setup/create-project.sh ../my-new-app

# Create with docs included
./setup/create-project.sh /var/www/html/my-app --keep-docs
```

### What Gets Copied

✅ **Included:**
- Core framework (`core/`)
- Application structure (`app/`)
- Controllers (Auth, User)
- Services (User, Auth, Password Reset)
- Validation rules
- Routes (web, api)
- Configuration files
- Public assets
- Database schema
- `.env.example`

❌ **Excluded:**
- Documentation (`docs/`) - unless `--keep-docs` flag used
- Tests (`tests/`)
- Development notes (`todo/`)
- Demo controllers
- Example views
- API testing pages
- Git history
- node_modules
- vendor (run `composer install` after copy)

### What Gets Cleaned

The script also removes example data from necessary files:

- **Route files** - Removes `require` statements for demo routes
- **Database seeders** - Removes DemoSeeder, ExampleSeeder, TestSeeder
- **Migrations** - Removes demo/example/test migrations
- **Controllers** - Removes DemoController, ExampleController
- **Views** - Removes demo/example view folders

### After Running

```bash
# 1. Navigate to new project
cd /path/to/new-project

# 2. Install dependencies
composer install

# 3. Configure environment
# .env file is already created, just edit it
nano .env

# 4. Set up database
mysql -u root -p < database/schema.sql

# 5. Start development
php -S localhost:8000 -t public
```

### Options

| Flag | Description |
|------|-------------|
| `--keep-docs` | Include documentation files in copy |

### Output

The script provides colored output showing:
- Progress for each step
- Files being copied
- Items being removed/cleaned
- Success/warning messages
- Next steps

### Requirements

- Bash 4.0+
- rsync
- git (optional, for repository initialization)
- openssl (optional, for APP_KEY generation)

### Permissions

The script automatically:
- Sets `755` permissions on all files
- Sets `775` permissions on `storage/` directory
- Creates `.gitkeep` files in empty storage folders
- Makes storage writable by web server

### Git Integration

If git is available, the script will:
- Initialize a new repository
- Create a comprehensive `.gitignore`
- Make initial commit with message: "Initial commit - Clean framework installation"

### Error Handling

The script will exit with an error if:
- No destination path provided
- Destination directory already exists
- Permission denied during copy

### Example Output

```
╔════════════════════════════════════════════════════════════╗
║         Framework Project Creator                         ║
╚════════════════════════════════════════════════════════════╝

Source:      /var/www/html/so-backend-framework
Destination: /var/www/html/my-app
Keep docs:   false

[1/10] Creating destination directory...
✓ Framework files copied

[2/10] Copying framework files...
✓ Framework files copied

[3/10] Removing demo and development files...
✓ Demo files removed

[4/10] Cleaning example data from route files...
✓ Route files cleaned

[5/10] Cleaning database seeders...
✓ Database seeders cleaned

[6/10] Cleaning example migrations...
✓ Migrations cleaned

[7/10] Creating storage directories...
✓ Storage directories created

[8/10] Setting permissions...
✓ Permissions set

[9/10] Creating environment file...
✓ .env file created from .env.example

[10/10] Creating project README...
✓ README.md created
✓ Git repository initialized

╔════════════════════════════════════════════════════════════╗
║         Project Created Successfully!                      ║
╚════════════════════════════════════════════════════════════╝

Next steps:

  1. cd /var/www/html/my-app
  2. composer install
  3. Configure your .env file
  4. Import database/schema.sql
  5. Configure web server → public/

Your clean framework is ready at:
/var/www/html/my-app
```

## Troubleshooting

### "Destination directory already exists"

The destination must be a new directory. Either:
- Choose a different path
- Remove the existing directory first

### "Permission denied"

Ensure you have write permissions to the destination parent directory:

```bash
# Check permissions
ls -la /var/www/html/

# Fix if needed (adjust owner as needed)
sudo chown -R $USER:$USER /var/www/html/
```

### "rsync: command not found"

Install rsync:

```bash
# Ubuntu/Debian
sudo apt-get install rsync

# CentOS/RHEL
sudo yum install rsync

# macOS
brew install rsync
```

## Tips

1. **Keep documentation for first project** - Use `--keep-docs` flag when creating your first project to have the docs available
2. **Version control** - The script initializes git automatically, but you may want to set up a remote repository
3. **Multiple projects** - You can create multiple projects from the same framework source
4. **Customize** - After creating a project, customize the README, composer.json, etc. for your specific application
