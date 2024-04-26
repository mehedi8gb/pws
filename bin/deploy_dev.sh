#!/bin/bash
shopt -s nocasematch
ENVIRONMENT="${1:-local}"
FILES='-f docker-compose.yml'

if [[ ! -e .env ]]
then
    cp .env.example .env
fi
docker compose $FILES down
if [ "$ENVIRONMENT" == "staging" ];
then
    docker compose $FILES up -d mariadb backend --build
else
    docker compose $FILES up -d --build
fi

docker compose exec backend sh ./bin/update_dev.sh

echo 'http://localhost:8090/'
