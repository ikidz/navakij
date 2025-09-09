#!/usr/bin/env sh
set -e

echo "✅ start.sh is running..."

# Default to php-fpm -F if no command is passed
if [ "$#" -eq 0 ]; then
  set -- php-fpm -F
fi

# Where the Laravel app lives (can override with env)
LARAVEL_APP_PATH="${LARAVEL_APP_PATH:-/var/www/html/navakij-batch}"

# --- CI2 writable dirs (targeted) ---
[ -d /var/www/html/application/cache ] && chmod -R 775 /var/www/html/application/cache || true
[ -d /var/www/html/application/logs  ] && chmod -R 775 /var/www/html/application/logs  || true
[ -d /var/www/html/application/cache ] && chown -R www-data:www-data /var/www/html/application/cache || true
[ -d /var/www/html/application/logs  ] && chown -R www-data:www-data /var/www/html/application/logs  || true

# --- Laravel (nested) setup ---
if [ -f "$LARAVEL_APP_PATH/artisan" ]; then
  echo "🔧 Laravel detected at: $LARAVEL_APP_PATH"

  # Writable dirs
  [ -d "$LARAVEL_APP_PATH/storage" ]         && chmod -R 775 "$LARAVEL_APP_PATH/storage"         && chown -R www-data:www-data "$LARAVEL_APP_PATH/storage" || true
  [ -d "$LARAVEL_APP_PATH/bootstrap/cache" ] && chmod -R 775 "$LARAVEL_APP_PATH/bootstrap/cache" && chown -R www-data:www-data "$LARAVEL_APP_PATH/bootstrap/cache" || true

  # Ensure .env exists (copy from example if missing)
  if [ ! -f "$LARAVEL_APP_PATH/.env" ] && [ -f "$LARAVEL_APP_PATH/.env.example" ]; then
    echo "📝 No .env found; copying from .env.example"
    cp "$LARAVEL_APP_PATH/.env.example" "$LARAVEL_APP_PATH/.env" || true
  fi

  # Composer install (only if needed, or COMPOSER_INSTALL=1 to force)
  if [ ! -d "$LARAVEL_APP_PATH/vendor" ] || [ "${COMPOSER_INSTALL:-0}" = "1" ]; then
    echo "📦 composer install in $LARAVEL_APP_PATH ..."
    (cd "$LARAVEL_APP_PATH" && composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader) || true
    [ -d "$LARAVEL_APP_PATH/vendor" ] && chown -R www-data:www-data "$LARAVEL_APP_PATH/vendor" || true
  fi

  # Generate app key if missing
  if ! grep -qs '^APP_KEY=' "$LARAVEL_APP_PATH/.env"; then
    echo "🔑 Generating APP_KEY ..."
    (cd "$LARAVEL_APP_PATH" && php artisan key:generate --force) || true
  fi

  # Warm caches (don't fail container if deps/env not fully ready)
  (cd "$LARAVEL_APP_PATH" && php artisan config:clear) || true
  (cd "$LARAVEL_APP_PATH" && php artisan config:cache) || true
  (cd "$LARAVEL_APP_PATH" && php artisan route:cache)  || true
  (cd "$LARAVEL_APP_PATH" && php artisan view:cache)   || true

  # Optional: run migrations in UAT
  if [ "${RUN_MIGRATIONS:-0}" = "1" ]; then
    echo "🗄  Running migrations (--force)…"
    (cd "$LARAVEL_APP_PATH" && php artisan migrate --force) || true
  fi
else
  echo "ℹ️ No Laravel at $LARAVEL_APP_PATH (skipping Laravel steps)"
fi

echo "🚀 Starting: $*"
exec docker-php-entrypoint "$@"
