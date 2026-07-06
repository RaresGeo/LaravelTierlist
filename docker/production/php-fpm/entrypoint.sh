#!/bin/sh
set -e

# Initialize storage directory if empty
# -----------------------------------------------------------
# If the storage directory is empty, copy the initial contents
# and set the correct permissions.
# -----------------------------------------------------------
if [ ! "$(ls -A /var/www/storage)" ]; then
  echo "Initializing storage directory..."
  cp -R /var/www/storage-init/. /var/www/storage
  chown -R www-data:www-data /var/www/storage
fi

# Remove storage-init directory
rm -rf /var/www/storage-init

# Ensure the uploaded-images volume is writable by the php-fpm workers.
# It's a named volume shared with nginx; on first creation Docker roots it at
# root:root, so www-data (the pool user) can't save uploads without this.
chown www-data:www-data /var/www/public/images

# Drop any stale config/route cache so migrate reads the runtime env
php artisan config:clear
php artisan route:clear

# Run Laravel migrations
# -----------------------------------------------------------
# Ensure the database schema is up to date.
# -----------------------------------------------------------
php artisan migrate --force

# Clear and cache configurations
# -----------------------------------------------------------
# Improves performance by caching config and routes.
# -----------------------------------------------------------
php artisan config:cache
php artisan route:cache

# Run the default command
exec "$@"
