UID = $$(id -u)

@all:
	cat Makefile

up:
	docker-compose up -d

down:
	docker-compose down

restart:
	./cmd.sh restart-service $(s)

configure: cmd.sh
	./cmd.sh copy-env-files

install: up
	docker-compose exec php-fpm chown -R $(UID):$(UID) /composer
	docker-compose exec --user $(UID) php-fpm composer install
	docker-compose exec --user $(UID) php-fpm php artisan migrate
	docker-compose exec --user $(UID) php-fpm php artisan key:generate
	docker-compose down && docker-compose up -d

upgrade: up
	docker-compose down
	docker-compose pull
	docker-compose build
	docker-compose up -d
	docker-compose exec -u $(UID) php-fpm composer update
	docker-compose exec -u $(UID) php-fpm php artisan migrate

logs: up
	docker-compose logs $(s)

logsf: up
	docker-compose logs -f $(s)

stan: phpstan phpcs security-check
	@echo "Running static analysis tools"

migrate:
	docker-compose exec -u $(UID) php-fpm php artisan migrate

shell: cmd.sh up
	./cmd.sh attach-to-shell $(s) $(u)

phpstan: up
	@echo "Running phpstan"
	docker-compose exec -u $(UID) php-fpm composer run-script phpstan

phpcs: up
	@echo "Running code sniffer"
	docker-compose exec -u $(UID) php-fpm composer run-script phpcs

phpcbf: up
	docker-compose exec -u $(UID) php-fpm composer run-script phpcbf

security-check:
	@echo "Running symfony security check"
	docker-compose exec -u $(UID) php-fpm composer run-script security-check

tinker: up
	docker-compose exec --user $(UID) php-fpm php artisan tinker
