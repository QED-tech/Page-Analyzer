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
	docker-compose exec php-fpm php artisan test

linter-test:
	make compose
	make test
	make compose-down

deploy:
	git push heroku main

compose:
	docker-compose up -d

compose-build:
	docker-compose build

compose-down:
	docker-compose down -v
