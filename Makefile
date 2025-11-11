.PHONY: help up down build restart logs ps clean attach-app

help: ## Show this help message
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2}'

up: ## Start all containers
	docker-compose up -d

down: ## Stop and remove all containers
	docker-compose down

build: ## Build or rebuild containers
	docker-compose build

restart: ## Restart all containers
	docker-compose restart

logs: ## Show logs from all containers
	docker-compose logs -f

ps: ## List all containers
	docker-compose ps

attach-app: ## Attach to PHP container
	docker-compose exec skill-test-app sh

clean: ## Stop containers and remove volumes
	docker-compose down -v