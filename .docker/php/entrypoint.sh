#!/usr/bin/env sh

if [ ! -d "vendor" ]; then
	echo "Vendor directory not found. Installing dependencies..."
	composer install
	bin/console assets:install
else
	echo "Vendor directory found. Skipping dependency installation."
fi

rr serve -c .rr.dev.yaml
