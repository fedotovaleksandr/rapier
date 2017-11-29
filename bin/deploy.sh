#!/usr/bin/env bash
echo "Install npm dependencies..."
npm i

echo "Install bower dependencies..."
node_modules/.bin/bower install

echo "Composer i"
composer install

echo "Run Migration..."
php bin/console d:m:m

echo "Clear Cache..."
php bin/console cache:clear