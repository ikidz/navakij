git-reset:
	git reset --hard

docker-remove:
	docker system prune -a --volumes

clear-logs:
	rm -rf laravel/storage/logs/laravel.log
	touch laravel/storage/logs/laravel.log
	chmod -R 777 laravel/storage/ laravel/bootstrap/cache/

uat-up:
	docker-compose -f uat.yml up -d
uat-init:
	docker-compose -f uat.yml build
	docker-compose -f uat.yml up -d
	docker-compose -f uat.yml exec lobsteryatch-ua-app composer install
uat-build:
	docker-compose -f uat.yml build
	docker-compose -f uat.yml up -d
uat-down:
	docker-compose -f uat.yml down -v
uat-start:
	docker-compose -f uat.yml start
uat-stop-app:
	docker-compose -f uat.yml stop lobsteryatch-ua-app
uat-stop:
	docker-compose -f uat.yml stop
uat-log:
	docker-compose -f uat.yml logs -f
uat-bash:
	docker-compose -f uat.yml exec lobsteryatch-ua-app bash
uat-sh:
	docker-compose -f uat.yml exec lobsteryatch-ua-app sh
uat-restart:
	docker-compose -f uat.yml restart

prod-up:
	docker-compose -f prod.yml up -d
prod-init:
	docker-compose -f prod.yml build
	docker-compose -f prod.yml up -d
	docker-compose -f prod.yml exec lobsteryatch-prod-app composer install
prod-build:
	docker-compose -f prod.yml build
	docker-compose -f prod.yml up -d
prod-up-composer:
	git reset --hard
	rm -rf laravel/vender laravel/bootstrap laravel/storage laravel/composer.lock
	git reset --hard
	chmod -R 777 laravel/storage/ laravel/bootstrap/cache/
	docker-compose -f prod.yml build
	docker-compose -f prod.yml up -d
	docker-compose -f prod.yml exec lobsteryatch-prod-app composer install
	docker-compose -f prod.yml exec lobsteryatch-prod-app php artisan cache:clear
	docker-compose -f prod.yml exec lobsteryatch-prod-app php artisan view:clear
	docker-compose -f prod.yml exec lobsteryatch-prod-app php artisan config:clear
	docker-compose -f prod.yml exec lobsteryatch-prod-app php artisan route:clear
	docker-compose -f prod.yml exec lobsteryatch-prod-app php artisan clear-compiled
	rm -rf laravel/storage/logs/laravel.log
	touch laravel/storage/logs/laravel.log
	chmod -R 777 laravel/storage/ laravel/bootstrap/cache/
	docker system prune -a --volumes
prod-down:
	docker-compose -f prod.yml down -v
prod-start:
	docker-compose -f prod.yml start
prod-stop-app:
	docker-compose -f prod.yml stop lobsteryatch-prod-app
prod-stop:
	docker-compose -f prod.yml stop
prod-log:
	docker-compose -f prod.yml logs -f lobsteryatch-prod-app
prod-bash:
	docker-compose -f prod.yml exec lobsteryatch-prod-app bash
prod-sh:
	docker-compose -f prod.yml exec lobsteryatch-prod-app sh
prod-restart:
	docker-compose -f prod.yml restart