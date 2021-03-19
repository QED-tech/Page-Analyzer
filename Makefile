install:
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
test:
	php artisan test
deploy:
	git push heroku main
