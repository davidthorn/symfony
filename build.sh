#!/bin/bash

if [ -f ./build/.install.lock ]; then
 echo "The install lock exists, delete it to continue"
 exit 1
fi

### Download composer
EXPECTED_CHECKSUM="$(php -r 'copy("https://composer.github.io/installer.sig", "php://stdout");')"
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
ACTUAL_CHECKSUM="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"

if [ "$EXPECTED_CHECKSUM" != "$ACTUAL_CHECKSUM" ]
then
    >&2 echo 'ERROR: Invalid installer checksum'
    rm composer-setup.php
    exit 1
fi

php composer-setup.php --quiet
rm composer-setup.php
## Composer Download completed

# Removed the contents of the app folder to have a clean install.
rm -rf app

# Install symfony project in the app folder.
./composer.phar create-project symfony/website-skeleton app

# Remove the composer, because we dont need it anymore
rm -rf composer.phar

# Build the project.
sudo docker-compose -f docker-compose.yml build --force-rm --pull --build-arg USER_ID=$(id -u)

