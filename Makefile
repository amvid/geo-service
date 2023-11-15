.PHONY: up
up:
	@docker-compose up

.PHONY: install
install:
	@docker-compose up -d
	@docker exec geo-service-app-dev sh -c "composer install"

.PHONY: update
update:
	@docker exec geo-service-app-dev sh -c "composer update"

.PHONY: migration
migration:
	docker exec geo-service-app-dev sh -c "php bin/console make migration"

.PHONY: migrate
migrate:
	@docker exec geo-service-app-dev sh -c "php bin/console d:m:m"

.PHONY: user
user:
	@docker exec -it geo-service-app-dev php bin/console app:create-user

.PHONY: ssh
ssh:
	@docker exec -it geo-service-app-dev sh

.PHONY: test
test:
	@docker-compose -f docker-compose.test.yaml up -d
	@docker exec geo-service-test-app sh -c "APP_ENV=test ./bin/console --no-interaction d:m:m"
	@docker exec geo-service-test-app sh -c "APP_ENV=test ./bin/console d:f:l --no-interaction"
	@docker exec geo-service-test-app sh -c "APP_ENV=test ./vendor/bin/phpunit"
	@docker-compose -f docker-compose.test.yaml down

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

.PHONY: airports
airports:
	@docker exec geo-service-app-dev sh -c "bin/console app:import-airports"

.PHONY: geo
geo:
	make currencies
	make timezones
	make regions
	make subregions
	make countries
	make states
	make cities
	make airports
