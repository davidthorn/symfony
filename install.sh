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

if [ ! -f build/.install.lock ]; then
  touch build/.install.lock
fi


