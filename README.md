[![CI](https://github.com/davidthorn/web-env/actions/workflows/build.yml/badge.svg?branch=symfony%2Fskeleton)](https://github.com/davidthorn/web-env/actions/workflows/build.yml)

# Symfony Skeleton - Docker

This docker project contains a basic symfony project, mysql server and also its own nginx server to use.

# Build -> Installation

In order for the project to run, the php image is required to be built.


The following command in the route directory of this project so that the php image can be built.
```bash
./build.sh
```

The build script does nothing more than tell docker which Dockerfile to use
and also it sets a build arg that is required within the dockerfile.

The command also informs docker that it must rebuild the image and also pull the newest version from docker hub.

```bash
sudo docker-compose -f docker-compose.yml build --force-rm --pull --build-arg USER_ID=$(id -u)
```

# Installation

Once the build step has been completed, the [`install.sh`](./install.sh) script can be executed.


