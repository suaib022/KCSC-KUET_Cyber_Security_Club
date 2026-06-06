# KCSC — KUET Cyber Security Club

A professional PHP + MySQL web application for the KUET Cyber Security Club, built with MVC-inspired architecture.

## 🚀 Features

- **Homepage** — Hero section, about, activities, events, team preview, and contact
- **Team Page** — Full member grid with profile cards
- **Join Page** — Member registration form with server-side validation
- **Database** — MySQL with PDO prepared statements
- **Security** — CSRF protection, XSS prevention, SQL injection protection
- **Flash Messages** — Toast notifications for success/error feedback
- **Responsive** — Mobile-friendly design with hamburger navigation

## 📁 Project Structure

```
KCSC-KUET_Cyber_Security_Club/
├── app/                    # Application code (NOT web-accessible)
│   ├── Controllers/        # Request handlers
│   ├── Models/             # Database models
│   ├── Services/           # Business logic (validation)
│   ├── Views/              # PHP templates
│   │   ├── layouts/        # Base HTML layout
│   │   ├── pages/          # Page-specific content
│   │   └── partials/       # Reusable components (header, nav, footer)
│   └── Helpers/            # Utility functions
├── config/                 # Configuration files
├── database/               # SQL schema
├── storage/                # Logs and uploads
├── public/                 # Web root (publicly accessible)
│   ├── assets/             # CSS, JS, images
│   ├── index.php           # Homepage entry
│   ├── join.php            # Join form entry
│   └── team.php            # Team page entry
├── .env                    # Environment config (gitignored)
├── .env.example            # Template for .env
├── .htaccess               # Protects non-public directories
└── README.md
```

## ⚙️ Setup Instructions

### Prerequisites

- **XAMPP** (or any Apache + PHP + MySQL stack)
- **PHP 7.4+** with PDO MySQL extension
- **MySQL 5.7+** or MariaDB

### 1. Clone the Repository

```bash
cd /Applications/XAMPP/xamppfiles/htdocs/
git clone <repo-url> KCSC-KUET_Cyber_Security_Club
```

### 2. Configure Environment

```bash
cd KCSC-KUET_Cyber_Security_Club
cp .env.example .env
```

Edit `.env` and fill in your database credentials:

```env
DB_HOST=localhost
DB_PORT=3306
DB_NAME=kcsc_db
DB_USER=root
DB_PASS=
```

### 3. Create the Database

**Option A: phpMyAdmin**
1. Open [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2. Import `database/database.sql`

**Option B: Command Line**
```bash
mysql -u root -p < database/database.sql
```

### 4. Access the Application

Navigate to:
```
http://localhost/KCSC-KUET_Cyber_Security_Club/public/
```

## 🔒 Security Features

| Feature | Implementation |
|---------|---------------|
| SQL Injection | PDO prepared statements with named placeholders |
| XSS | `htmlspecialchars()` via `e()` helper on all output |
| CSRF | Session-based token verification on form submissions |
| Directory Access | `.htaccess` blocks `app/`, `config/`, `storage/`, `.env` |
| Credentials | Environment variables via `.env` (gitignored) |
| Error Handling | Errors logged to file; details hidden in production |
| Session Security | HttpOnly, SameSite=Strict, strict mode enabled |

## 🛠️ Configuration

### Debug Mode

Set `APP_DEBUG=true` in `.env` to see detailed errors during development. **Always set to `false` in production.**

### Virtual Host (Recommended)

For optimal security, configure Apache to serve directly from the `public/` directory:

```apache
<VirtualHost *:80>
    ServerName kcsc.local
    DocumentRoot "/Applications/XAMPP/xamppfiles/htdocs/KCSC-KUET_Cyber_Security_Club/public"

    <Directory "/Applications/XAMPP/xamppfiles/htdocs/KCSC-KUET_Cyber_Security_Club/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Add to `/etc/hosts`:
```
127.0.0.1   kcsc.local
```

## 📝 License

© 2026 KCSC. All rights reserved.
