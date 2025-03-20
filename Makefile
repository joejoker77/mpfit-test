docker-franken-up: generate-env
	@docker compose --env-file ./.env.local -f ./docker-compose.yaml up --build

docker-franken-down:
	@docker compose --env-file ./.env.local -f ./docker-compose.yaml down

docker-franken-bash:
	@docker exec -it mpfit_franken bash

generate-env:
	@if [ ! -f ./.env.local ]; then \
		cp ./.env.dist ./.env.local && \
		if [ "$(shell uname)" = "Darwin" ]; then \
			sed -i '' "s/^DB_PASSWORD=/DB_PASSWORD=$(shell openssl rand -hex 8)/" ./.env.local; \
			sed -i '' "s/^APP_SECRET=/APP_SECRET=$(shell openssl rand -hex 8)/" ./.env.local; \
		else \
			sed -i "s/^DB_PASSWORD=/DB_PASSWORD=$(shell openssl rand -hex 8)/" ./.env.local; \
			sed -i "s/^APP_SECRET=/APP_SECRET=$(shell openssl rand -hex 8)/" ./.env.local; \
		fi \
	fi
