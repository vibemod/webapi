# Include variables
include .env.dist
-include .env
export

############################################################
# HELP #####################################################
############################################################
all:
	@awk 'BEGIN {FS = ":.*##"; printf "Usage:\n  make \033[36m<target>\033[0m\n\nTargets:\n"}'
	@grep -h -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[36m%-20s\033[0m %s\n", $$1, $$2}'

############################################################
# PROJECT ##################################################
############################################################
.PHONY: init
init: ## Init project for the first time
	cp -n .env.example .env || true
	cp -n config/local.neon.example config/local.neon || true

.PHONY: install
install: install-php ## Install all dependencies

.PHONY: install-php
install-php: ## Install PHP dependencies
	composer install

.PHONY: setup
setup: ## Create and setup project skeleton
	mkdir -p var/log var/tmp/cache var/tmp/sessions var/tmp/proxies
	chmod -R a+rw var/log var/tmp

.PHONY: clean
clean: ## Clear project folders
	find var/tmp -mindepth 1 ! -name '.gitignore' -type f,d -exec rm -rf {} +
	find var/log -mindepth 1 ! -name '.gitignore' -type f,d -exec rm -rf {} +

.PHONY: warmup
warmup: ## Warm project (called during starting container)
	$(MAKE) setup
	$(MAKE) clean
	$(MAKE) db-migrate
	$(MAKE) db-proxy
	$(MAKE) setup

############################################################
# DEV ######################################################
############################################################
.PHONY: cs
cs: ## Check PHP code style
	XDEBUG_CONFIG=off vendor/bin/phpcs --cache=var/tmp/codesniffer.dat --standard=ruleset.xml src tests db

.PHONY: csf
csf: ## Fix PHP code style
	XDEBUG_CONFIG=off vendor/bin/phpcbf --cache=var/tmp/codesniffer.dat --standard=ruleset.xml src tests db

.PHONY: phpstan
phpstan: ## Check static analysis
	XDEBUG_CONFIG=off vendor/bin/phpstan analyse -c phpstan.neon --memory-limit=512M

.PHONY: test
test: test-app test-e2e ## Run PHP phpunit tests

.PHONY: test-e2e
test-e2e: ## Run PHP phpunit with E2E suitcase
	vendor/bin/phpunit -c phpunit.xml --stderr --testsuite E2E --no-coverage

.PHONY: test-app
test-app: ## Run PHP phpunit with App suitcase
	vendor/bin/phpunit -c phpunit.xml --stderr --testsuite App --no-coverage

.PHONY: test-coverage-text
test-coverage-text: ## Generate PHP phpunit text code coverage
	mkdir -p var/tmp
	XDEBUG_MODE=coverage vendor/bin/phpunit -c phpunit.xml --coverage-text=var/tmp/coverage/coverage.txt --colors=never --testsuite Unit

.PHONY: test-coverage-html
test-coverage-html: ## Generate PHP phpunit html code coverage
	mkdir -p var/tmp
	XDEBUG_MODE=coverage vendor/bin/phpunit -c phpunit.xml --coverage-html var/tmp/coverage/html --colors --testsuite Unit

.PHONY: dev
dev: ## Run PHP development server for API
	NETTE_DEBUG=${NETTE_DEBUG} php -S 0.0.0.0:${APP_PORT} public/index.php

############################################################
# DATABASE #################################################
############################################################
db-migrate: ## Run migrations
	NETTE_DEBUG=1 bin/console migrations:migrate --no-interaction

db-diff: ## Run migrations
	NETTE_DEBUG=1 bin/console migrations:diff --allow-empty-diff

db-proxy: ## Generate proxies
	NETTE_DEBUG=1 bin/console orm:generate-proxies

db-fixtures-dev: ## Run development fixtures
	NETTE_DEBUG=1 bin/console doctrine:fixtures:load --no-interaction --fixtures=db/Fixtures/Shared --fixtures=db/Fixtures/Development

db-fixtures-prod: ## Run production fixtures
	NETTE_DEBUG=1 bin/console doctrine:fixtures:load --no-interaction --fixtures=db/Fixtures/Shared --fixtures=db/Fixtures/Production

############################################################
# MCP ######################################################
############################################################
.PHONY: mcp-inspect
mcp-inspect: ## Run MCP inspector
	npx @modelcontextprotocol/inspector

.PHONY: mcp-stdio
mcp-stdio: ## Run MCP inspector for stdio server
	npx @modelcontextprotocol/inspector php bin/console mcp:server
