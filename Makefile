setup:
	composer update
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
	docker-compose up -d

compose-build:
	docker-compose build

compose-down:
	docker-compose down -v
