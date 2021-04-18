setup:
	composer install

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
