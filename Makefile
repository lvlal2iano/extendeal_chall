#!/bin/bash
DOCKER_PHP = $(shell basename $(CURDIR))_web_1
DOCKER_DB = $(shell basename $(CURDIR))_mysql_1
DB_PASS = developer
ENVFILE ?= .env.example

init: ## Init the project
	clear
	docker-compose up --build --force-recreate -d --remove-orphans
	docker exec -it ${DOCKER_PHP} composer install
	docker exec -it ${DOCKER_PHP} cp -f $(ENVFILE) .env
	docker exec -it ${DOCKER_PHP} php artisan key:generate
	docker exec -it ${DOCKER_PHP} php artisan octane:install --server="swoole"
	docker exec -it ${DOCKER_PHP} php artisan migrate:fresh --seed
	docker exec -it ${DOCKER_PHP} php artisan optimize:clear
	docker exec -it ${DOCKER_PHP} composer dump-autoload --optimize
	docker exec -it ${DOCKER_PHP} php artisan test
	docker exec -it ${DOCKER_PHP} php artisan octane:start --server="swoole" --host="0.0.0.0"
	find . \
	-path ./db -prune \
	-o -path ./.git -prune \
	-o -exec chown  www-data:www-data {} +

stop:
	clear
	docker-compose stop

run:
	clear
	docker-compose up

ssh: ## ssh's into the PHP container
	clear
	docker exec -it ${DOCKER_PHP} bash

restart: ## Restart the containers
	make stop
	make run

