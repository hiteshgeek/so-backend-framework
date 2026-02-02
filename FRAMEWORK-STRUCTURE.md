# Framework Structure Guide

> **For Developers**: This document explains which files/folders are part of the framework core and should NOT be modified in your projects.

---

## Quick Reference

| Folder/File | Touch? | Purpose |
|-------------|--------|---------|
| `core/` | ❌ NO | Framework engine |
| `bootstrap/` | ❌ NO | Framework bootstrapping |
| `setup/` | ❌ NO | Framework setup scripts |
| `tests/` | ❌ NO | Framework tests |
| `docs/` | ❌ NO | Framework documentation |
| `app/` | ✅ YES | Your application code |
| `config/` | ✅ YES | Your configuration |
| `routes/` | ✅ YES | Your routes |
| `resources/` | ✅ YES | Your views/lang |
| `public/` | ✅ YES | Your public assets |
| `database/` | ✅ YES | Your migrations/seeds |
| `storage/` | ✅ YES | Your storage |

---

## ❌ DO NOT MODIFY (Framework Core)

These folders contain the framework engine. Any modifications will be **overwritten** when you update the framework.

```
so-backend-framework/
│
├── core/                          # 🔒 FRAMEWORK ENGINE - DO NOT TOUCH
│   ├── ActivityLog/               # Activity logging system
│   ├── Api/                       # API response helpers
│   ├── Application.php            # Main application class
│   ├── Auth/                      # Authentication system
│   │   └── TwoFactor/             # 2FA support
│   ├── Cache/                     # Caching system
│   │   └── Drivers/               # Cache drivers (File, Redis, etc.)
│   ├── Console/                   # CLI commands
│   │   └── Commands/              # Built-in commands
│   ├── Container/                 # Dependency injection container
│   ├── Database/                  # Database abstraction layer
│   ├── Debug/                     # Debugging tools
│   ├── Events/                    # Event dispatcher
│   ├── Exceptions/                # Exception handling
│   ├── Http/                      # HTTP request/response
│   ├── Image/                     # Image processing
│   │   ├── Contracts/
│   │   └── Drivers/
│   ├── Localization/              # i18n/l10n system
│   │   ├── Formatters/
│   │   ├── Middleware/
│   │   ├── Pluralization/
│   │   └── Validation/
│   ├── Logging/                   # Logging system
│   ├── Mail/                      # Email system
│   ├── Media/                     # Media management
│   ├── Middleware/                # Core middleware
│   ├── Model/                     # Base model & ORM
│   │   ├── Relations/
│   │   └── Traits/
│   ├── Notifications/             # Notification system
│   ├── Queue/                     # Job queue system
│   ├── Routing/                   # Router
│   ├── Security/                  # Security utilities
│   ├── Session/                   # Session handling
│   ├── Support/                   # Helper utilities
│   ├── Validation/                # Validation system
│   │   └── Rules/
│   ├── Video/                     # Video processing
│   │   └── Drivers/
│   └── View/                      # View/template engine
│
├── bootstrap/                     # 🔒 FRAMEWORK BOOTSTRAP - DO NOT TOUCH
│   ├── app.php                    # Application bootstrap
│   └── cache/                     # Bootstrap cache
│
├── setup/                         # 🔒 FRAMEWORK SETUP - DO NOT TOUCH
│   ├── create-project.sh          # Project scaffolding
│   ├── setup-databases.sh         # Database setup
│   ├── rename-framework.sh        # Rename project
│   ├── install-vhost-*.sh         # VHost setup
│   ├── cleanup-vhost-*.sh         # VHost cleanup
│   ├── line-count.sh              # Code metrics
│   ├── SETUP.md                   # Setup guide
│   └── README.md                  # Setup documentation
│
├── tests/                         # 🔒 FRAMEWORK TESTS - DO NOT TOUCH
│   ├── bootstrap.php              # Test bootstrap
│   ├── TestHelper.php             # Test utilities
│   ├── Unit/                      # Unit tests
│   ├── Integration/               # Integration tests
│   └── examples/                  # Test examples
│
├── docs/                          # 🔒 FRAMEWORK DOCS - DO NOT TOUCH
│   ├── md/                        # Markdown documentation
│   ├── api/                       # API documentation
│   ├── features/                  # Feature documentation
│   └── security/                  # Security documentation
│
├── todo/                          # 🔒 FRAMEWORK TODO - DO NOT TOUCH
│
├── .vscode/                       # 🔒 IDE SETTINGS - DO NOT TOUCH
│
├── phpunit.xml                    # 🔒 Test configuration
├── sixorbit                       # 🔒 CLI tool
└── composer.json                  # 🔒 Dependencies (modify carefully)
```

---

## ✅ CAN MODIFY (Your Application)

These folders are for your application code. Customize freely.

```
so-backend-framework/
│
├── app/                           # ✅ YOUR APPLICATION CODE
│   ├── Controllers/               # Your controllers
│   │   ├── Auth/                  # Auth controllers (can extend)
│   │   ├── Api/                   # API controllers
│   │   └── ...                    # Your custom controllers
│   ├── Models/                    # Your models
│   ├── Middleware/                # Your middleware
│   ├── Services/                  # Your services
│   ├── Repositories/              # Your repositories
│   ├── Providers/                 # Your service providers
│   ├── Requests/                  # Your form requests
│   ├── Jobs/                      # Your queue jobs
│   ├── Notifications/             # Your notifications
│   ├── Validation/                # Your validation rules
│   └── Constants/                 # Your constants
│
├── config/                        # ✅ YOUR CONFIGURATION
│   ├── app.php                    # Application config
│   ├── database.php               # Database config
│   ├── auth.php                   # Auth config
│   ├── cache.php                  # Cache config
│   ├── mail.php                   # Mail config
│   ├── queue.php                  # Queue config
│   ├── session.php                # Session config
│   ├── security.php               # Security config
│   └── ...                        # Other configs
│
├── routes/                        # ✅ YOUR ROUTES
│   ├── web.php                    # Web routes
│   └── api.php                    # API routes
│
├── resources/                     # ✅ YOUR RESOURCES
│   ├── views/                     # Your blade/PHP views
│   └── lang/                      # Your translations
│
├── public/                        # ✅ YOUR PUBLIC FILES
│   ├── index.php                  # Entry point (modify carefully)
│   ├── assets/                    # Your assets (CSS, JS, images)
│   └── uploads/                   # User uploads
│
├── database/                      # ✅ YOUR DATABASE FILES
│   ├── migrations/                # Your migrations
│   └── seeders/                   # Your seeders
│
├── storage/                       # ✅ YOUR STORAGE
│   ├── logs/                      # Application logs
│   ├── cache/                     # Application cache
│   └── ...                        # Other storage
│
├── .env                           # ✅ YOUR ENVIRONMENT (never commit)
└── .env.example                   # ✅ Environment template
```

---

## Summary

### If you want to...

| Task | Where to do it |
|------|----------------|
| Add a new API endpoint | `app/Controllers/` + `routes/api.php` |
| Create a new model | `app/Models/` |
| Add custom middleware | `app/Middleware/` |
| Add a service class | `app/Services/` |
| Add validation rules | `app/Validation/` |
| Change database settings | `config/database.php` |
| Add translations | `resources/lang/` |
| Add CSS/JS | `public/assets/` |
| Add a cron job | `app/Jobs/` |

### Never modify these (they are part of framework core):
- Anything in `core/`
- Anything in `bootstrap/`
- Anything in `setup/`
- Anything in `tests/`
- Anything in `docs/`

---

## Updating Framework

When the framework is updated (via git subtree pull or manual sync):

1. **Preserved**: All your `app/`, `config/`, `routes/`, `resources/`, `public/`, `database/` files
2. **Overwritten**: `core/`, `bootstrap/`, `setup/`, `tests/`, `docs/`

This is why you should never modify framework core files - your changes will be lost on update.

---

## Questions?

If you're unsure whether to modify a file, ask yourself:
- Is it in `core/`? → **Don't touch it**
- Is it in `app/`? → **Go ahead**
- Is it a config file? → **Go ahead**
- Is it a route file? → **Go ahead**
