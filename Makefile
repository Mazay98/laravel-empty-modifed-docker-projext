include .env

CURRENT_DIR := $(shell pwd)
CURRENT_UID := $(shell id -u)
CURRENT_GID := $(shell id -g)
CURRENT_USER := $(CURRENT_UID)":"$(CURRENT_GID)
APP_DIR := $(CURRENT_DIR)"/www"

initenv:
	@cp ${CURRENT_DIR}/www/.env.example ${CURRENT_DIR}/www/.env
	@sed -i 's/APP_NAME=pawnshop/APP_NAME=${APP_NAME}/g' ${CURRENT_DIR}/www/.env
	@sed -i 's/APP_URL=http:\/\/localhost/APP_URL=${PROTOCOL}:\/\/${NGINX_HOST}/g' ${CURRENT_DIR}/www/.env
	@sed -i 's/DB_HOST=127.0.0.1/DB_HOST=${DB_HOST}/g' ${CURRENT_DIR}/www/.env
	@sed -i 's/DB_DATABASE=laravel/DB_DATABASE=${DB_DATABASE}/g' ${CURRENT_DIR}/www/.env
	@sed -i 's/DB_USERNAME=root/DB_USERNAME=${DB_USER}/g' ${CURRENT_DIR}/www/.env
	@sed -i 's/DB_PASSWORD=/DB_PASSWORD=${DB_PASSWORD}/g' ${CURRENT_DIR}/www/.env
	@sed -i 's/MAIL_HOST=smtp.mailtrap.io/MAIL_HOST=${MAIL_HOST}/g' ${CURRENT_DIR}/www/.env
	@sed -i 's/MAIL_PORT=2525/MAIL_PORT=${MAIL_PORT}/g' ${CURRENT_DIR}/www/.env

install:
	@docker-compose build
	@make initenv
	@make yarn-install
	@docker-compose run --rm phpfpm composer install
	@docker-compose run --rm phpfpm php artisan key:generate
	@make yarn-compile


uninstall:
	@docker-compose down -v
	@rm ${CURRENT_DIR}/www/.env
	@rm -rf ${CURRENT_DIR}/www/vendor
	@rm -rf ${CURRENT_DIR}/www/node_modules
	@rm -rf ${CURRENT_DIR}/logs/nginx/*.log

# App
up:
	@docker-compose up -d

start:
	@docker-compose start

stop:
	@docker-compose stop

resetdb:
	@docker-compose exec phpfpm php artisan migrate:fresh --seed

# Composer
composer-require:
	@docker-compose exec phpfpm composer require

composer-install:
	@docker-compose exec phpfpm composer install

composer-update:
	@docker-compose exec phpfpm composer update

node:
	@docker run --rm -it -v $(APP_DIR):/app -w /app --user $(CURRENT_USER) node:${NODE_VERSION} /bin/sh

# Yarn
yarn-install:
	@docker run --rm -v $(APP_DIR):/app -w /app --user $(CURRENT_USER) node:${NODE_VERSION} yarn install

yarn-watch:
	@docker run --rm -v $(APP_DIR):/app -w /app --user $(CURRENT_USER) node:${NODE_VERSION} yarn watch-poll

yarn-compile:
	@docker run --rm -v $(APP_DIR):/app -w /app --user $(CURRENT_USER) node:${NODE_VERSION} yarn run development
