#!/usr/bin/env bash

environment=${1-dev}
echo "Environment set to <${environment}>."

echo "Update docker"
docker-compose exec --user=www-data php bash bin/deploy.sh