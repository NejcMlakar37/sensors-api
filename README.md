# Production Sensors API
API for production sensors data gathering adn fetching.

PHP 8.2

### Project setup:
```shell
git clone https://git.krah-gruppe.de/R-NEJML/production-sensors-api.git
git checkout origin develop
cd ./production-sensors-api
docker-compose -f docker-compose.dev.yml up -d
docker exec -it dev /bin/bash
composer install
php artisan migrate
php artisan db:seed --class=DaatabaseSeeder
php artisan optimize
php artisan serve --host=0.0.0.0 --port=8888
```
App should be available at http://127.0.0.1:8888/

You can see all API endpoints at http://127.0.0.1:8888/docs/api

### Database manipulation
To setup database:
```shell
php artisan migrate
```
To initialize data:
```shell
php artisan db:seed
```
To reset database run:
```shell
php artisan migrate:reset
```

### Docker manipulation:
Start docker environment:
```shell
docker-compose up
```
Stop docker environment:
```shell
docker-compose down
```
Go inside docker container:
```shell
docker exec -it <docker-container-name> /bin/bash
```
