#!/usr/bin/env sh

if [ -d "vendor" ]; then
  echo "Vendor folder exists. Skipping 'composer install'."
else
  composer install
fi

if [ -f "bin/rr" ]; then
  echo "RR binary exists. Skipping 'vendor/bin/rr get-binary'."
else
  vendor/bin/rr get-binary -f v2023.3.4 --location bin
  chmod +x bin/rr
fi

bin/console assets:install
bin/rr serve -c .rr.dev.yaml

