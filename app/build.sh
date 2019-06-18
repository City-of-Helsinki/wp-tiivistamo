#!/bin/bash

# stop and remove all containers
(docker stop $(docker ps -a -q) && docker rm $(docker ps -a -q)) &> /dev/null

# composer install
docker run -it --rm -v $(pwd):/app --workdir /app composer/composer install --no-dev

# npm install
docker run -it --rm -v $(pwd):/app --workdir /app onefastsnail/development:legacy npm install

# npm build
docker run -it --rm -v $(pwd):/app --workdir /app onefastsnail/development:legacy npm run build

# bring up the docker stack
docker-compose up -d --build