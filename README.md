### sources
./app/Interview

### tests
./tests

### to run environment
docker-compose up

//next in the docker container

cp .env.example .env

composer install

### to run tests (in the docker container)
./vendor/bin/phpunit
