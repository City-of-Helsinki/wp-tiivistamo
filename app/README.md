# A WordPress Project

A WordPress build with a Dockerized LEMP stack.

## API integrations

Supposedly the Oodi events can be found from https://api.hel.fi/linkedevents/v1/event/?format=json&location=tprek:51342 (Oodi keskustakirjasto) or from https://api.hel.fi/linkedevents/v1/event/?format=json&location=tprek:55955 (Oodi centeral library) as found from the Service Map provided by City of Helsinki.

## Initial Setup

1. Copy and configure `env/.env.example` to `env/.env` (ensure all passwords are strong and filled in)
2. Copy and configure `auth.json.example` to `auth.json` for Composer
3. Run `./build.sh`
4. Pull in the [database](#Database)
5. Visit [http://localhost](http://localhost)

## Usage

* To spin up the Docker stack run `em docker this`
* To begin to develop, run `em npm run dev`
* Due to the `src` / `dist` build nature, the above must be running when making file and ACF changes.
* All WordPress / PHP libraries must go through [Composer](https://getcomposer.org/) using a 3 digit versioning convention.
* All front end dependencies must go through [NPM](https://www.npmjs.com/) using a 3 digit versioning convention.

## Deployment

This project is somewhat different from the earlier Dockerpress projects when it comes to deployment. The project uses the latest (at the time of writing) Dockerpress setup which has been built with CircleCI & Docker in mind, but *we are still currently using Flightplan to deploy*.

### Notes on this project

To run deployments with Flightplan, you will actually need to run the Flightplan commands inside the Docker container like this:

```bash
# Run bash inside the Docker container
docker exec -it $(docker ps -qf "name=oodi_wordpress") bash
# Use yarn to run node commands as usual (without the em helper, as we're inside the container)
yarn fly test:staging
```

This uses the `SSH_AUTH_SOCK` defined in `docker-compose.yml` to pass the SSH key inside the container. This is specific to this project, as deployments without the SSH agent would not work.

### General Flightplan info

We currently use Node [Flightplan](https://github.com/pstadler/flightplan) for deployment.

**Note:** the below uses a reference to `/tmp/agent.sock` which is not available on Mac but rather Linux only, so you will need to create symbolic link to the Mac equivalent if you want this working on your Mac.

* `em fly ping:staging` to do a test ping connection
* `em fly test:staging` to test the target configuration is ok
* `em fly deploy:staging` to deploy the staging

### Database

Note that the above project-specific points on Flightplan naturally also apply to this section.

#### General Flightplan info
We have database push and pull tasks available through [Flightplan](https://github.com/pstadler/flightplan). Whether you can push a database into a target is set in the `flightplan/project.conf.js` file.

First run a test to see if you can connect to your desired target `em fly test:production`.

If ok now we can sync our databases.

* `em fly dbPull:production` to pull the production database to your local database
* `em fly dbPush:staging` to push your local database to staging

Both push and pull tasks perform a `WP CLI` search and replace. However multisite setup will require a little amend to those queries.

## Everblox

Everblox will seamlessly integrate into this build, with Gulp automatically copying and watching the PHP, SCSS and JS.

* `em everblox add BLOCK NAME`

* `em everblox add example my-new-block` will clone the `example` block to a new block called `my-new-block`

The `block` parameter is the block git repository name, omitting the `-block` suffix, which is added due to the lack of project namespaces available in Bitbucket repository URLs.

The `name` parameter allows you to clone a block under a different name. This way it allows you to build blocks from another block as a base or simply run multiple versions of a block in the future using different unique names.

The `name` parameter can be omitted if you want the name to simply be the name of the block repository your cloning, ie if unique already.

* `em everblox add example` will clone and create a block called `example`

## Composer

To run these [Composer](https://getcomposer.org/) related commands

* `em composer install --no-dev`
* `em composer update --no-dev`

## WP CLI

To run [WP CLI](http://wp-cli.org/) related commands

* `em wp user list`
* `em wp search-replace 'http://old.domain' 'http://new.domain'`

## Security

To run some basic security tests, you can use WP Scan:

* `docker run --rm wpscanteam/wpscan -u https://www.evermade.fi --enumerate u --basic-auth demo:demo`

## Project Details

## Theme

* [Head into the Swiss theme](src/wp-content/themes/swiss/README.md) for more

## Gulp

* If you need to add more files to the Gulp watch, for example a WP plugin, a JS or CSS library, then add it to the corresponding index in the `gulpfile.js` paths object.

## Tests

* Coming soon!

## Care

See the heading `Deployment` for details on this project.

## Found a bug?

If you have an issue or have found a bug, please [create an issue](https://bitbucket.org/evermade/dockerpress/issues/new).

## Contributors

* Paul Stewart
