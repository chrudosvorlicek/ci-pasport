# CIIS - pasportization

## About

This project serves as platform to show and manage various data in CzechInevest.

## Installation

1. Clone repository
2. Run:
    * `$ make configure`
    * `$ make install`

## For daily development

* **turn on**: `$ make up` or `docker-compose up -d`
* **turn off**: `$ make down` or`docker-compose down`
* **upgrade**: `$ make upgrade`

Following commands can be used in running container using composer

* **phpstan**: `$ make phpstan`
* **code sniffer**: `$ make phpcs`
* **code beautifier**: `$ make phpcbf`
* **security audit**: `$ make security-audit`
* **security check**: `$ make security-check`
