#!/usr/bin/env bash
echo "Install npm dependencies..."
npm i

echo "Install bower dependencies..."
node_modules/.bin/bower install

echo "Composer i"
composer install --no-dev

echo "Run Migration..."
php bin/console d:m:m --env=prod

echo "Clear Cache..."
php bin/console cache:clear --env=prod