all: build install

run:
	docker-compose -f docker/docker-compose.local.yml up

install:
	docker-compose -f docker/docker-compose.tools.yml run composer install

update:
	docker-compose -f docker/docker-compose.tools.yml run composer update

test:
	docker-compose -f docker/docker-compose.tools.yml run composer test

.PHONY: run build install update test
