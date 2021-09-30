# POC Siren crawler

## Requirements

- [Docker](https://docs.docker.com/engine/)
- [Docker Compose](https://docs.docker.com/compose/)

## Stack

- Php 7.4
- MySQL 8
- Symfony 5.3
- Nginx

## Project Setup

1. Clone the repository

2. Create your local config files

    ```shell
    cp docker-env.dist docker-en
    cp docker-compose.yml.dist docker-compose.yml
    cp .env .env.local
    ```

3. Update these files and replace the `<variables>` with your data

4. Build, start and install the project with make

    ```shell
    make project-build
    make composer-install
    make init-database
    ```

5. Go to localhost:<port_defined_in_docker_compose>/

    Example: http://localhost:8000/

## Project Usage

This project feature an example implementation of the [Strategy pattern](https://en.wikipedia.org/wiki/Strategy_pattern) 
with Symfony service container (DependencyInjection).

You can either parse the csv or call the Insee api :

### Search with CSV

1. Get your csv data from
[insee website](https://www.data.gouv.fr/fr/datasets/base-sirene-des-entreprises-et-de-leurs-etablissements-siren-siret/)
and put it in the `/data` directory at the root of the project.
2. Rename the csv file `siren_delta.csv`
3. Go to `http://localhost:8000/api/siren/{siren-number-to-search}/csv`

### Search with API

1. First create a free [insee account](https://api.insee.fr/)
2. follow their instruction to generate a bearer token and update your `.env.local`
3. Go to `http://localhost:8000/api/siren/{siren-number-to-search}/api`