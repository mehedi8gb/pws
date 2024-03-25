#!/bin/bash
files='-f docker-compose.yml'
docker compose $files down
docker compose $files up -d --build

docker compose exec backend sh ./bin/update_dev.sh

echo 'http://localhost:8090/'
