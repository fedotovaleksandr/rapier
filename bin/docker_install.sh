#!/bin/sh

environment=${1-dev}
echo "Environment set to <${environment}>."

echo "Install bower dependencies..."
node_modules/.bin/bower install

echo "Create DB..."
docker-compose exec php php bin/console doctrine:database:create --if-not-exists --env=${environment}

echo "Create Schema..."
docker-compose exec php php bin/console doctrine:schema:create --env=${environment}

echo "Run migrations..."
docker-compose exec php php bin/console d:m:m --env=${environment}

echo "Done!"
