#!/usr/bin/env bash
echo "Running migrations..."
php artisan migrate --force

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Caching views..."
php artisan view:cache

echo "Seeding default admin..."
php artisan tinker --execute="\$user = \App\Models\User::where('email', 'admin@pointcare.com')->first(); if (\$user) { \$user->role = 'admin'; \$user->save(); }"


