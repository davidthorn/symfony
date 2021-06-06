#!/bin/bash

function exec() {
  sudo docker-compose exec php $@
}

sudo docker-compose up -d

# Production Dependencies
exec composer require monolog/monolog \
                      twig/twig \
                      doctrine/annotations \
                      doctrine/doctrine-bundle \
                      doctrine/orm symfony/validator

# Development Dependencies
exec composer require --dev symfony/maker-bundle symfony/profiler-pack

# Update all
exec composer update

# Generate the secrets file for development
exec bin/console secrets:generate-keys --env=dev

echo "Enter the name of the database user {DATABASE_USER}:"
exec bin/console secrets:set DATABASE_USER --env=dev

echo "Enter the name of the database {DATABASE_NAME}:"
exec bin/console secrets:set DATABASE_NAME --env=dev

echo "Enter the password for the database {DATABASE_PASSWORD}:"
exec bin/console secrets:set DATABASE_PASSWORD --env=dev

if [ ! -f build/.install.lock ]; then
  touch build/.install.lock
fi