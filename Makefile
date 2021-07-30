run-dev:
	docker-compose up -d --build
	docker-compose exec node sh -c "yarn install && yarn run dev"

run-watch:
	docker-compose exec node sh -c "yarn install && yarn run watch"

run-build-dev:
	docker-compose exec node sh -c "yarn install && yarn run dev"

run-yarn-install:
	docker-compose exec node sh -c "yarn install"

run-migrate:
	docker-compose exec php sh -c "php artisan migrate"

run-seed:
	docker-compose exec php sh -c "php artisan db:seed"

stop-dev:
	docker-compose down -v