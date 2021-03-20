start:
	php artisan serve --host 0.0.0.0

setup:
	composer install
	cp -n .env.example .env|| true
	php artisan key:gen --ansi
	touch database/database.sqlite
	php artisan migrate
	php artisan db:seed
	npm install

lint:
	composer phpcs

lint-fix:
	composer phpcbf

console:
	php artisan tinker

test:
	php artisan test

deploy:
	git push heroku main

compose:
	docker-compose up

compose-build:
	docker-compose build

compose-setup: compose-build
	docker-compose run web make setup

compose-db:
	docker-compose exec db psql -U postgres

compose-down:
	docker-compose down -v
