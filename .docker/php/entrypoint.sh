#!/usr/bin/env sh

if [ -d "vendor" ]; then
	echo "Vendor folder exists. Skipping 'composer install'."
else
	composer install
fi

if [ -f "bin/rr" ]; then
	echo "RR binary exists. Skipping 'vendor/bin/rr get-binary'."
else
	bin/console assets:install
	vendor/bin/rr get-binary -f v2024.1.0 --location bin
	chmod +x bin/rr
fi

bin/rr serve -c .rr.dev.yaml
