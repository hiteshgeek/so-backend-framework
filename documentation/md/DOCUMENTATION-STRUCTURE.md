# Documentation Structure

All documentation files are located in the `/documentation` folder (renamed from `docs` to avoid routing conflicts).

## Web Access

Access documentation through the web interface:

- **Main Documentation Hub**: [http://localhost/so-backend-framework/docs](http://localhost/so-backend-framework/docs)
- **Comprehensive Guide**: [http://localhost/so-backend-framework/docs/comprehensive](http://localhost/so-backend-framework/docs/comprehensive)
- **Individual Guides**: [http://localhost/so-backend-framework/docs/{filename}](http://localhost/so-backend-framework/docs/)

## Available Documentation

### Core Documentation Files

| File | Web URL | Description |
|------|---------|-------------|
| **COMPREHENSIVE-GUIDE.md** | `/docs/comprehensive` | Complete guide covering all features, implementation status, and examples |
| **README.md** | `/docs/readme` | Framework overview and features |
| **INDEX.md** | `/docs/index` | Documentation navigation hub |
| **SETUP.md** | `/docs/setup` | Installation and setup guide |
| **CONFIGURATION.md** | `/docs/configuration` | Configuration system guide |
| **QUICK-START.md** | `/docs/quick-start` | Fast reference guide |
| **RENAME-PROCESS.md** | `/docs/rename` | Framework renaming guide |
| **FRAMEWORK-BRANDING.md** | `/docs/branding` | Branding reference |

### Special Files

| File | Purpose |
|------|---------|
| **DOCUMENTATION-STRUCTURE.md** | This file - explains documentation organization |

## Folder Structure

```
documentation/
+-- COMPREHENSIVE-GUIDE.md          # Main comprehensive documentation
+-- README.md                       # Framework overview
+-- INDEX.md                        # Navigation hub
+-- SETUP.md                        # Setup guide
+-- CONFIGURATION.md                # Configuration guide
+-- QUICK-START.md                  # Quick reference
+-- RENAME-PROCESS.md               # Rename guide
+-- FRAMEWORK-BRANDING.md           # Branding reference
+-- DOCUMENTATION-STRUCTURE.md      # This file
```

## Implementation Details

### Controller

**Location**: `app/Controllers/DocsController.php`

Handles all documentation routing:
- `index()` - Documentation hub page
- `comprehensive()` - Comprehensive guide page
- `show($file)` - Individual documentation pages

### Views

**Location**: `resources/views/docs/`

- `index.php` - Documentation hub with cards for each guide
- `comprehensive.php` - Comprehensive guide with markdown rendering
- `show.php` (planned) - Template for individual documentation pages

### Routes

**Location**: `routes/web.php`

```php
Router::get('/docs', [DocsController::class, 'index']);
Router::get('/docs/comprehensive', [DocsController::class, 'comprehensive']);
Router::get('/docs/{file}', [DocsController::class, 'show']);
```

## Why "documentation" Instead of "docs"?

The folder was renamed from `docs/` to `documentation/` to prevent routing conflicts. When the folder was named `docs/`, Apache would treat `/docs` as a physical directory and redirect to `/docs/`, causing issues with the routing system.

By renaming it to `documentation/`, the `/docs` URL is now exclusively handled by the routing system, while the physical files remain accessible to the application code.

## Adding New Documentation

To add new documentation:

1. Create a new `.md` file in the `documentation/` folder
2. Add the file to the `$allowedFiles` array in `DocsController::show()`
3. Update the `index.php` view to include a card for the new documentation
4. Update this file to reflect the new documentation

Example:

```php
// In DocsController.php
$allowedFiles = [
    'my-new-guide' => 'MY-NEW-GUIDE.md',
    // ... other files
];
```

## Markdown Rendering

The comprehensive guide page includes basic markdown-to-HTML conversion:
- Headers (H1-H4)
- Bold and italic text
- Code blocks and inline code
- Lists
- Links
- Paragraphs

For more complex markdown rendering, consider integrating a dedicated markdown parser library.

---

**Last Updated**: 2026-01-29
