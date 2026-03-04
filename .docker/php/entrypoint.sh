#!/usr/bin/env sh
set -e

if [ ! -d "vendor" ]; then
	echo "Vendor directory not found. Installing dependencies..."
	composer install
	bin/console assets:install
else
	echo "Vendor directory found. Skipping dependency installation."
fi

frankenphp run --config frankenphp/Caddyfile.dev
