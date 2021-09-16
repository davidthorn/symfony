# Symfony Skeleton - Docker

> THIS README IS OUTDATED AND I NEED TO UPDATE IT

The build,install scripts install a [symfony/website-skeleton](https://github.com/symfony/website-skeleton) application into the app folder and then install some custom packages that can be used to create a website/api.

The symfony project will be serve its website pages, using nginx, and also save all of its data into a mysql server. 

All of these services are run using docker and all configured using the [docker-compose.yml](./docker-compose.yml) within in the root directory of the project.


## Destroy Step

If this is the first time that you have run this script and on this machine, then the [destroy.sh](./destroy.sh) script is not really required.

The script is there to make sure that all resources are removed that could cause the build phase a problem.

If the script has been ran before, then it will remove all volumes, containers and images that have been created and services started for this folder.

Be warned, if you make changes to the [Dockerfile](./build/Dockerfile) and have built it prior to making the changes, docker my have some volume problems when creating the php container.

If files and folders do not exist in the php container, then restarting docker seems to fix the problem. Its definitely not the solution, but it helps to fix the issue.

## Build Step

In order for the application to run, the symfony service requires for its image to be built.

The reason for this step is to make sure that we do not encounter any file permission problems during the installation step.

Run the following command in the route directory of this project so that the php image can be built.
```bash
./build.sh
```

The build script does nothing more than tell docker which Dockerfile to use
and also it sets a `--build-arg` to `USER_ID=$(id -u)` that is required within the dockerfile.

By setting this `--build-arg` it informs the [Dockerfile](./build/Dockerfile), which user id is used as the owner and group for all files in the working directory and also which user will be used to execute all commands.

The command also informs docker that it must rebuild the image and also pull the newest image tag from docker hub.

```bash
sudo docker-compose -f docker-compose.yml build --force-rm --pull --build-arg USER_ID=$(id -u)
```

## Installation

Once the build step has been completed, the [`install.sh`](./install.sh) script can be executed.

Be aware that the install.sh script will create a [.install.lock](./build/.install.lock) file within the [build](./build) folder upon a successful installation.

The lock file, protects the [build.sh](./build.sh) from deleting any work that has been carried out in the app folder.

## Security

Prior to starting developing the project, some work is required to secure the environment variables used within the project.

If the [install.sh](./install.sh) script has been run, then you would have entered the user, password, database name in for the `dev` environment.

These values are stored within the [app/config/secrets](./app/config/secrets) folder.

In order for these values to be used, the [doctrine.yaml](./app/config/packages/doctrine.yaml) needs to be updated:

The [doctrine.yaml](./app/config/packages/doctrine.yaml) will probably look like this:

```yaml
doctrine:
    dbal:
        url: '%env(resolve:DATABASE_URL)%'

        # IMPORTANT: You MUST configure your server version,
        # either here or in the DATABASE_URL env var (see .env file)
        #server_version: '13'
```

Replace the `doctrine` property with the code below:

```yaml
doctrine:
    dbal:
        dbname: '%env(DATABASE_NAME)%'
        host: mysql
        port: 3306
        user: '%env(DATABASE_USER)%'
        password: '%env(DATABASE_PASSWORD)%'
        driver: pdo_mysql
        server_version: '5.7'
        charset: UTF8
```

Next remove all `doctrine` information from the [app/.env](./app/.env) file.
Or at least comment out all uncommented lines.

```bash
###> doctrine/doctrine-bundle ###
# Format described at https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#connecting-using-a-url
# IMPORTANT: You MUST configure your server version, either here or in config/packages/doctrine.yaml
#
# DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
# DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7"
DATABASE_URL="postgresql://db_user:db_password@127.0.0.1:5432/db_name?serverVersion=13&charset=utf8"
###< doctrine/doctrine-bundle ###
```

## Extract APP_SECRET from .env to secrets.

Run the following command to extract the APP_SECRET to a secrets files.

