network:
	docker network create leaderboard 2>/dev/null || true

db-up: network
	docker compose -f docker/db/docker-compose.yml up -d

db-down:
	docker compose -f docker/db/docker-compose.yml down

up: network
	docker compose up -d

down:
	docker compose down

build:
	docker compose build --no-cache

restart: down up

shell:
	docker compose exec app bash

migrate:
	docker compose exec app php artisan migrate

migrate-fresh:
	docker compose exec app php artisan migrate:fresh --seed

artisan:
	docker compose exec app php artisan $(filter-out $@,$(MAKECMDGOALS))

logs:
	docker compose logs -f

logs-app:
	docker compose logs -f app

setup: network db-up up
	docker compose exec app php artisan key:generate --no-interaction
	docker compose exec app php artisan migrate

%:
	@:
