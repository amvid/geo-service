#!/usr/bin/env sh

if [ ! -d "vendor" ]; then
	echo "Vendor directory not found. Installing dependencies..."
	composer install
else
	echo "Vendor directory found. Skipping dependency installation."
fi

bin/console assets:install

if [ ! -f "bin/rr" ]; then
	echo "RoadRunner binary not found. Downloading..."
	vendor/bin/rr get-binary -f v2024.1.5 --location bin
	chmod +x bin/rr
else
	echo "RoadRunner binary found. Skipping download."
fi

bin/rr serve -c .rr.dev.yaml
