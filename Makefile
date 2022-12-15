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

.PHONE: ssh
ssh:
	@docker exec -it app sh
