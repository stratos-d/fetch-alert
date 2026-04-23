# Executables (local)
DOCKER_COMP = docker compose

# Docker containers
PHP_CONT = $(DOCKER_COMP) exec php

# Executables
PHP      = $(PHP_CONT) php
COMPOSER = $(PHP_CONT) composer
SYMFONY  = $(PHP) bin/console

# Misc
.DEFAULT_GOAL = help
.PHONY        : help build up start down logs sh composer vendor sf cc test test-init seed analyze pint phpstan prettier lint

## —— 🎵 🐳 The Symfony Docker Makefile 🐳 🎵 ——————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9\./_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Docker 🐳 ————————————————————————————————————————————————————————————————
build: ## Builds the Docker images
	@$(DOCKER_COMP) build --pull --no-cache

up: ## Start the docker hub in detached mode (no logs)
	@$(DOCKER_COMP) up --detach

start: build up ## Build and start the containers

down: ## Stop the docker hub
	@$(DOCKER_COMP) down --remove-orphans

logs: ## Show live logs
	@$(DOCKER_COMP) logs --tail=0 --follow

sh: ## Connect to the FrankenPHP container
	@$(PHP_CONT) sh

bash: ## Connect to the FrankenPHP container via bash so up and down arrows go to previous commands
	@$(PHP_CONT) bash

test: ## Start tests with phpunit, pass the parameter "c=" to add options to phpunit, example: make test c="--group e2e --stop-on-failure"
	@$(eval c ?=)
	@$(DOCKER_COMP) exec -e APP_ENV=test php bin/phpunit --testdox $(c)

test-init: ## Init test database
	@$(SYMFONY) doctrine:database:drop --env=test --force --if-exists
	@$(SYMFONY) doctrine:database:create --env=test
	@$(SYMFONY) doctrine:schema:create --env=test

seed: ## Load dev sample data from resources/sql/seed.sql
	@cat resources/sql/seed.sql | $(DOCKER_COMP) exec -T database mysql -uapp -papp app


## —— Composer 🧙 ——————————————————————————————————————————————————————————————
composer: ## Run composer, pass the parameter "c=" to run a given command, example: make composer c='req symfony/orm-pack'
	@$(eval c ?=)
	@$(COMPOSER) $(c)

vendor: ## Install vendors according to the current composer.lock file
vendor: c=install --prefer-dist --no-dev --no-progress --no-scripts --no-interaction
vendor: composer

## —— Symfony 🎵 ———————————————————————————————————————————————————————————————
sf: ## List all Symfony commands or pass the parameter "c=" to run a given command, example: make sf c=about
	@$(eval c ?=)
	@$(SYMFONY) $(c)

cc: c=c:c ## Clear the cache
cc: sf

## Quality
pint:
	@$(PHP_CONT) vendor/bin/pint

phpstan:
	@$(PHP_CONT) vendor/bin/phpstan analyse --memory-limit=512M

prettier:
	@docker run --rm -v "$(CURDIR):/work" -w /work node:22-alpine npx --yes prettier --write "**/*.{yaml,yml,md}"

lint:
	@docker run --rm \
		-e RUN_LOCAL=true \
		-e DEFAULT_BRANCH=main \
		-e FILTER_REGEX_EXCLUDE='(config/reference\.php|docs/.*\.md)' \
		-e VALIDATE_CHECKOV=false \
		-e VALIDATE_TRIVY=false \
		-e VALIDATE_BIOME_FORMAT=false \
		-e VALIDATE_BIOME_LINT=false \
		-e VALIDATE_ENV=false \
		-e VALIDATE_PHP_BUILTIN=false \
		-e VALIDATE_PHP_PHPCS=false \
		-e VALIDATE_PHP_PHPSTAN=false \
		-e VALIDATE_PHP_PINT=false \
		-e VALIDATE_PHP_PSALM=false \
		-v "$(CURDIR):/tmp/lint" \
		ghcr.io/super-linter/super-linter:slim-v8

analyze: pint phpstan prettier
