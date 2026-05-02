# This script checks prerequisites and prints exact setup commands.
# It avoids making system-wide changes automatically.

Write-Host "=== Equipment Tracker Laravel Server Setup ===" -ForegroundColor Cyan

function Test-Command {
    param([string]$Name)
    return [bool](Get-Command $Name -ErrorAction SilentlyContinue)
}

$phpOk = Test-Command "php"
$composerOk = Test-Command "composer"
$mysqlOk = Test-Command "mysql"

Write-Host "PHP installed:      $phpOk"
Write-Host "Composer installed: $composerOk"
Write-Host "MySQL CLI installed:$mysqlOk"

if (-not $phpOk -or -not $composerOk -or -not $mysqlOk) {
    Write-Warning "Install missing prerequisites, then re-run this script."
    Write-Host "After install, run:"
    Write-Host "  composer create-project laravel/laravel equipment-server"
    Write-Host "  cd equipment-server"
    Write-Host "  composer require laravel/sanctum"
    Write-Host "  php artisan vendor:publish --provider=\"Laravel\\Sanctum\\SanctumServiceProvider\""
    Write-Host "  php artisan migrate"
    Write-Host "  php artisan serve"
    exit 1
}

Write-Host "All prerequisites found." -ForegroundColor Green
Write-Host "Next commands:" -ForegroundColor Green
Write-Host "  composer create-project laravel/laravel equipment-server"
Write-Host "  cd equipment-server"
Write-Host "  composer require laravel/sanctum"
Write-Host "  php artisan vendor:publish --provider=\"Laravel\\Sanctum\\SanctumServiceProvider\""
Write-Host "  php artisan migrate"
Write-Host "  php artisan serve"
