#!/usr/bin/env sh

composer install
bin/console assets:install

vendor/bin/rr get-binary -f v2024.1.1 --location bin
chmod +x bin/rr

bin/rr serve -c .rr.dev.yaml
