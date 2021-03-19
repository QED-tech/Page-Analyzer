install:
	composer install
lint:
	composer phpcs
lint-fix:
	composer phpcbf
test:
	php artisan test
