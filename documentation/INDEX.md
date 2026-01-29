# Documentation Index

Welcome to the SO Framework documentation! This directory contains all guides and references for using and customizing the framework.

## 📚 Quick Navigation

### Getting Started
- **[README.md](README.md)** - Complete framework overview and features
- **[SETUP.md](SETUP.md)** - Complete installation and setup guide
- **[QUICK-START.md](QUICK-START.md)** - Fast reference for common tasks

### Configuration
- **[CONFIGURATION.md](CONFIGURATION.md)** - Complete configuration system guide
- **[FRAMEWORK-BRANDING.md](FRAMEWORK-BRANDING.md)** - Framework naming and branding reference
- **[RENAME-PROCESS.md](RENAME-PROCESS.md)** - Step-by-step manual rename process

---

## 📖 Documentation by Topic

### Installation & Setup

| Document | Description | Time to Read |
|----------|-------------|--------------|
| [README.md](README.md) | Framework features and overview | 5 min |
| [SETUP.md](SETUP.md) | Installation instructions | 10 min |
| [QUICK-START.md](QUICK-START.md) | Quick reference | 2 min |

### Configuration & Customization

| Document | Description | Time to Read |
|----------|-------------|--------------|
| [CONFIGURATION.md](CONFIGURATION.md) | Configuration system explained | 15 min |
| [FRAMEWORK-BRANDING.md](FRAMEWORK-BRANDING.md) | Rename framework - complete reference | 10 min |
| [RENAME-PROCESS.md](RENAME-PROCESS.md) | Rename framework - step by step | 10 min |

---

## 🎯 Common Tasks

### I want to...

#### Install the Framework
1. Read [README.md](README.md) for overview
2. Follow [SETUP.md](SETUP.md) for installation
3. Use [QUICK-START.md](QUICK-START.md) for testing

#### Configure the Framework
1. Read [CONFIGURATION.md](CONFIGURATION.md)
2. Edit `.env` file
3. Use `config()` helper in code

#### Rename the Framework
**Option 1: Automated (30 seconds)**
```bash
../rename-framework.sh "Your Name" "your-db" "vendor/pkg"
```

**Option 2: Manual (10 minutes)**
1. Follow [RENAME-PROCESS.md](RENAME-PROCESS.md)

**Option 3: Reference**
1. Check [FRAMEWORK-BRANDING.md](FRAMEWORK-BRANDING.md)

#### Learn the Configuration System
1. Read [CONFIGURATION.md](CONFIGURATION.md)
2. Check examples in [QUICK-START.md](QUICK-START.md)
3. Experiment with `.env` file

#### Understand Project Structure
See [README.md](README.md) - Directory Structure section

---

## 📋 Document Summaries

### README.md
**Purpose:** Framework overview
**Contains:**
- Features list
- Requirements
- Installation overview
- Usage examples
- Project structure
- Security features

**Best for:** First-time users, overview seekers

---

### SETUP.md
**Purpose:** Complete installation guide
**Contains:**
- Database setup
- Server configuration
- Testing endpoints
- Troubleshooting
- Example usage

**Best for:** Installing the framework, production deployment

---

### QUICK-START.md
**Purpose:** Fast reference
**Contains:**
- How to change framework name
- Quick configuration
- Test commands
- One-command solutions

**Best for:** Experienced users, quick lookups

---

### CONFIGURATION.md
**Purpose:** Configuration system deep dive
**Contains:**
- How config system works
- Environment variables reference
- Using config in code
- Best practices
- Dynamic SQL generation
- Examples and patterns

**Best for:** Understanding how configuration works, advanced usage

---

### FRAMEWORK-BRANDING.md
**Purpose:** Complete renaming reference
**Contains:**
- All files that need changes
- Exact line numbers
- Summary tables
- Automated script
- Verification checklist

**Best for:** Planning custom rename, understanding what files contain framework name

---

### RENAME-PROCESS.md
**Purpose:** Step-by-step rename guide
**Contains:**
- 7 detailed steps
- Before/after examples
- Verification commands
- Troubleshooting
- Quick reference commands

**Best for:** Manual rename, learning the process, Windows users

---

## 🔍 Find What You Need

### By Skill Level

**Beginner:**
1. [README.md](README.md) - Start here
2. [SETUP.md](SETUP.md) - Install and setup
3. [QUICK-START.md](QUICK-START.md) - Quick reference

**Intermediate:**
1. [CONFIGURATION.md](CONFIGURATION.md) - Config system
2. [RENAME-PROCESS.md](RENAME-PROCESS.md) - Customization

**Advanced:**
1. [FRAMEWORK-BRANDING.md](FRAMEWORK-BRANDING.md) - Deep reference
2. Source code and examples

### By Task Type

**Installation:**
- [SETUP.md](SETUP.md)
- [README.md](README.md)

**Configuration:**
- [CONFIGURATION.md](CONFIGURATION.md)
- [QUICK-START.md](QUICK-START.md)

**Customization:**
- [RENAME-PROCESS.md](RENAME-PROCESS.md)
- [FRAMEWORK-BRANDING.md](FRAMEWORK-BRANDING.md)

**Reference:**
- [QUICK-START.md](QUICK-START.md)
- [FRAMEWORK-BRANDING.md](FRAMEWORK-BRANDING.md)

---

## 🚀 Quick Links

**Essential Commands:**
```bash
# Setup database
mysql -u root -p < ../database/migrations/setup.sql

# Rename framework (automated)
../rename-framework.sh "Name" "db" "vendor/pkg"

# Regenerate SQL
php ../database/migrations/generate-setup.php

# Test API
curl http://localhost:8000/api/test
```

**Essential Files:**
- Configuration: `../.env`
- Routes: `../routes/web.php`, `../routes/api.php`
- Models: `../app/Models/`
- Controllers: `../app/Controllers/`

---

## 📝 Documentation Standards

All documentation in this folder follows these standards:

✅ **Clear Headers** - H1 for title, H2 for sections
✅ **Code Examples** - Always include working examples
✅ **Commands** - Show exact commands to run
✅ **Verification** - Include test/verify steps
✅ **Troubleshooting** - Common issues and solutions

---

## 🔄 Keeping Documentation Updated

When you change the framework:

1. **Change framework name in `.env`**
   - Docs using `config('app.name')` update automatically

2. **Add new features**
   - Update relevant documentation
   - Add examples
   - Update this INDEX

3. **Fix issues**
   - Add to troubleshooting sections
   - Update commands if they change

---

## 💡 Tips for Reading

- 📖 Read in order for first time: README → SETUP → CONFIGURATION
- 🎯 Jump to specific doc for specific task
- ⚡ Use QUICK-START for fast reference
- 🔍 Use INDEX (this file) to find what you need

---

## 🆘 Still Need Help?

If you can't find what you need:

1. Check [CONFIGURATION.md](CONFIGURATION.md) for config issues
2. Check [SETUP.md](SETUP.md) for installation issues
3. Check source code comments
4. Check the implementation plan at `~/.claude/plans/`

---

## 📊 Documentation Coverage

| Topic | Covered | Document |
|-------|---------|----------|
| Installation | ✅ | SETUP.md |
| Configuration | ✅ | CONFIGURATION.md |
| Routing | ✅ | README.md |
| Database | ✅ | SETUP.md, README.md |
| Models | ✅ | README.md, SETUP.md |
| Controllers | ✅ | README.md |
| Middleware | ⚠️ Partial | README.md |
| Security | ⚠️ Partial | README.md, SETUP.md |
| API | ✅ | SETUP.md, README.md |
| Customization | ✅ | RENAME-PROCESS.md, FRAMEWORK-BRANDING.md |
| Deployment | ⚠️ Partial | SETUP.md |

---

## 📅 Last Updated

This index was last updated: 2026-01-29

For the latest documentation, check the source files in this directory.

---

**Happy coding!** 🚀
