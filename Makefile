.PHONY: up
up:
	@docker compose up

.PHONY: dev
dev:
	@docker compose up

.PHONY: coldstart
coldstart:
	-rm -rf vendor
	-rm -rf bin/rr
	@docker compose up

.PHONY: install
install:
	@docker compose up -d
	@docker exec geo-service-app-dev sh -c "composer install"

assets:
	@docker exec geo-service-app-dev sh -c "bin/console assets:install"

.PHONY: update
update:
	@docker exec geo-service-app-dev sh -c "composer update"

.PHONY: migration
migration:
	docker exec geo-service-app-dev sh -c "php bin/console make migration"

.PHONY: migrate
migrate:
	@docker exec geo-service-app-dev sh -c "php bin/console d:m:m"

openapi:
	@docker exec -it geo-service-app-dev sh -c "bin/console nelmio:apidoc:dump --format=yaml > openapi.yaml"

cache:
	@docker exec geo-service-app-dev sh -c "bin/console cache:clear"

.PHONY: user
user:
	@docker exec -it geo-service-app-dev php bin/console app:create-user

.PHONY: ssh
ssh:
	@docker exec -it geo-service-app-dev sh

.PHONY: test
test:
	@docker compose -f docker-compose.test.yaml up -d
	@docker exec geo-service-test-app sh -c "APP_ENV=test ./bin/console --no-interaction d:m:m"
	@docker exec geo-service-test-app sh -c "APP_ENV=test ./bin/console d:f:l --no-interaction"
	@docker exec geo-service-test-app sh -c "APP_ENV=test ./vendor/bin/phpunit"

.PHONY: test-down
test-down:
	@docker compose -f docker-compose.test.yaml down -v --timeout=0

.PHONY: regions
regions:
	@docker exec geo-service-app-dev sh -c "bin/console app:import-regions"

.PHONY: subregions
subregions:
	@docker exec geo-service-app-dev sh -c "bin/console app:import-subregions"

.PHONY: timezones
timezones:
	@docker exec geo-service-app-dev sh -c "bin/console app:import-timezones"

.PHONY: currencies
currencies:
	@docker exec geo-service-app-dev sh -c "bin/console app:import-currencies"

.PHONY: countries
countries:
	@docker exec geo-service-app-dev sh -c "bin/console app:import-countries"

.PHONY: states
states:
	@docker exec geo-service-app-dev sh -c "bin/console app:import-states"

.PHONY: cities
cities:
	@docker exec geo-service-app-dev sh -c "bin/console app:import-cities"

.PHONY: sync-capitals
sync-capitals:
	@docker exec geo-service-app-dev sh -c "bin/console app:sync-capitals"

.PHONY: sync-cities-with-iata
sync-cities-with-iata:
	@docker exec geo-service-app-dev sh -c "bin/console app:sync-cities-with-iata"

.PHONY: airports
airports:
	@docker exec geo-service-app-dev sh -c "bin/console app:import-airports"

.PHONY: airports2
airports2:
	@docker exec geo-service-app-dev sh -c "bin/console app:import-airports2"

nationalities:
	@docker exec geo-service-app-dev sh -c "bin/console app:import-nationalities"

.PHONY: geo
geo:
	make currencies
	make timezones
	make regions
	make subregions
	make countries
	make states
	make cities
	make sync-capitals
	make sync-cities-with-iata
	make airports
	make nationalities
