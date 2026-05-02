# Equipment Tracker Server (Laravel + MySQL)

This folder contains a ready-to-copy Laravel API implementation for a client-server architecture.

Because PHP/Composer/MySQL are not installed in this environment, this is provided as a fully commented scaffold.
Once prerequisites are installed, copy these files into a fresh Laravel project and run migrations.

## 1) Prerequisites

- PHP 8.2+
- Composer 2+
- MySQL 8+

## 2) Create Laravel API Project

```powershell
composer create-project laravel/laravel equipment-server
cd equipment-server
```

## 3) Configure Database

Create database:

```sql
CREATE DATABASE equipment_tracker;
```

Update `.env`:

```env
APP_NAME=EquipmentTracker
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=equipment_tracker
DB_USERNAME=root
DB_PASSWORD=
```

## 4) API Auth + CORS

```powershell
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

Set CORS origin to client app URL (for example `http://localhost:3000`).

## 5) Add This Scaffold Code

Copy the contents from `server/laravel-api` into your generated Laravel project root.

## 6) Run Migrations and Start API

```powershell
php artisan migrate
php artisan serve
```

API base URL:

`http://127.0.0.1:8000/api`

## 7) Client-Server Flow

- Client app calls Laravel API endpoints.
- Laravel performs validation and business rules.
- MySQL stores equipment and assignment lifecycle.
- Sanctum protects authenticated routes.

## 8) Run With Apache HTTP Server

You can run Laravel on Apache instead of `php artisan serve`.

### A) Apache Modules to Enable

- `rewrite_module`
- `headers_module`

### B) Point Apache to the `public` Folder

Set Laravel app `DocumentRoot` to your project `public` directory:

`E:/VS_Projects/ghpagesdemo2/equipment-server/public`

### C) VirtualHost Example (Windows/XAMPP or Apache)

```apache
<VirtualHost *:80>
	ServerName equipment.local
	DocumentRoot "E:/VS_Projects/ghpagesdemo2/equipment-server/public"

	<Directory "E:/VS_Projects/ghpagesdemo2/equipment-server/public">
		AllowOverride All
		Require all granted
		Options Indexes FollowSymLinks
	</Directory>

	ErrorLog "logs/equipment-error.log"
	CustomLog "logs/equipment-access.log" common
</VirtualHost>
```

### D) Hosts File Entry (Windows)

Edit:

`C:/Windows/System32/drivers/etc/hosts`

Add:

```text
127.0.0.1 equipment.local
```

### E) Laravel `.env` for Apache URL

```env
APP_URL=http://equipment.local
```

### F) First-Time Laravel Commands

Run once in the Laravel project root:

```powershell
php artisan migrate
php artisan key:generate
php artisan config:clear
```

Then restart Apache and open:

`http://equipment.local`

API base URL:

`http://equipment.local/api`

### G) Common Apache/Laravel Notes

- Keep `AllowOverride All` enabled so Laravel routes work via `.htaccess`.
- Ensure `storage` and `bootstrap/cache` are writable by Apache.
- Do not run `php artisan serve` when using Apache VirtualHost.
