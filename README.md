# DockerPress

A Dockerrrrizzzed WordPress installation. This framework provides you with a PHP, MariaDB, NGINX stack all pre configured to work out the box.

## Requirements

* `em` mentioned below is our little Evermade helper that should be installed on your host machine, and can be found here: [https://bitbucket.org/evermade/em-helper](https://bitbucket.org/evermade/em-helper)

## Deployment

Eventually deployments will happen automatically when code is pushed to the `master` branch, but this is not yet the case.

See [this Confluence page](https://evermade.atlassian.net/wiki/spaces/DOC/pages/580911105/CI) for more details.

To set up CircleCI from scratch, follow the Confluence page instructions and define the following env vars in CircleCI:

```
DOCKERHUB_REPO
DOCKER_PASS
DOCKER_USER
DROPLET_IP
DROPLET_USER
WP_THEME_NAME
```

## Usage

[Head into the app readme to begin.](app/README.md)

### Persistent storage

The `/data` folder holds persistent data such as databases. We could also use this folder to store logs etc.

### Database

~~There is a phpMyAdmin container running to give you a database management tool. This can be accessed from [http://NAME.em87.io:8080](http://NAME.em87.io:8080)~~

The database is stored on the host machine at `/data/mariadb`

Credentials are stored `/app/env/.env`

Port `3306` is also exposed to your host so you can use connect to mysql locally if desired.

### Useful

* Refer to the Docker docs for more about commands [https://docs.docker.com/engine/reference/commandline/cli/](https://docs.docker.com/engine/reference/commandline/cli/)
* For docker-compose commands refer to [https://docs.docker.com/compose/reference/](https://docs.docker.com/compose/reference/)
* To install Docker on mac [https://docs.docker.com/docker-for-mac/](https://docs.docker.com/docker-for-mac/)
* To install Docker and/or Docker compose [https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-compose-on-ubuntu-14-04](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-compose-on-ubuntu-14-04)
* The app code is located in `/app`
* The nginx public serving code should be in `/app/dist`


## Contributors

* Paul Stewart
* Jaakko Alajoki
* Juha Lehtonen
* Pekka Wallenius
* Tuomas Hirvonen
* Joonas Pyhtilä
