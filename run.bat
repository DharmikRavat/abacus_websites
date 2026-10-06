@echo off
title Abacus Website - Laravel Server
echo ========================================================
echo   Starting Abacus Website (Laravel Development Server)
echo ========================================================

rem Check if custom PHP path exists
set PHP_BIN=php
if exist "D:\php8.3\php.exe" (
    set PHP_BIN=D:\php8.3\php.exe
)

rem Open browser after a short delay
start "" http://127.0.0.1:8000

echo Server running at http://127.0.0.1:8000
echo Press Ctrl+C to stop the server.
echo ========================================================
"%PHP_BIN%" artisan serve --host=127.0.0.1 --port=8000

pause
