#!/usr/bin/env sh

# DEVELOPMENT ONLY

#composer install

#vendor/bin/rr get-binary -f v2023.3.4 --location bin
#bin/console assets:install
bin/console cache:clear
bin/console cache:clear --env=prod

bin/rr serve -c .rr.yaml