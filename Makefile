.PHONY: up
up:
	@docker-compose up -d

.PHONY: install
install:
	@docker-compose up -d
	@docker exec app sh -c "composer install"

.PHONY: migration
migration:
	docker exec app sh -c "php bin/console make migration"

.PHONY: migrate
migrate:
	@docker exec app sh -c "php bin/console d:m:m"

.PHONY: ssh
ssh:
	@docker exec -it app sh

.PHONY: test
test:
	@docker exec app sh -c "./vendor/bin/phpunit"

.PHONY: regions
regions:
	@docker exec app sh -c "bin/console app:import-regions"

.PHONY: subregions
subregions:
	@docker exec app sh -c "bin/console app:import-subregions"

.PHONY: timezones
timezones:
	@docker exec app sh -c "bin/console app:import-timezones"

.PHONY: currencies
currencies:
	@docker exec app sh -c "bin/console app:import-currencies"

.PHONY: countries
countries:
	@docker exec app sh -c "bin/console app:import-countries"

.PHONY: states
states:
	@docker exec app sh -c "bin/console app:import-states"

.PHONY: cities
cities:
	@docker exec app sh -c "bin/console app:import-cities"

.PHONY: airports
airports:
	@docker exec app sh -c "bin/console app:import-airports"

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
