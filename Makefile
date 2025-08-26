# Load variables from .env file
ifneq (,$(wildcard .env))
    include .env
    export
endif

# Defining variables
COMPOSE = docker-compose
DOCKER = docker
APP_CONTAINER = test-task-app
DB_CONTAINER = test-task-db

# Initializing and building the project
init:
	cp .env.example .env || true
	$(COMPOSE) up -d --build

	@echo "⏳ Очікуємо поки MySQL стане доступним..."
	@sleep 15
	@echo "✅ База готова!"

	$(DOCKER) exec -i $(APP_CONTAINER) composer install
	$(DOCKER) exec -i $(APP_CONTAINER) php console migrate
	$(DOCKER) exec -i $(APP_CONTAINER) php console seed

# Up containers in detached mode
up:
	$(COMPOSE) up -d

# Stopping and removing containers
down:
	$(COMPOSE) down

# Rebuilding containers
rebuild:
	$(COMPOSE) up -d --build

# Accessing the app container
shell:
	$(COMPOSE) exec $(APP_CONTAINER) bash

.PHONY: init down rebuild shell up
