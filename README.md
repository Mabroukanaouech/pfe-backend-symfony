Project Name API
============

## Introduction

Project Name is a symfony 4 project designed to serve REST api on top of jwt authentication.

## Requirements

You can use this project  on your personal web-server, you will need to fulfill the respective requirements.

#### Web server

Nginx / Apache
PHP v7.1.3
MySQL / MariaDB
PHP Extension: cli, intl, xml, curl, mbstring, bcmath, gd, imap, zip

### Installing

After cloning the project repository and under the root directory.

#### Installing dependency

For the first time only you'll need to install dependencies with the following command :

```
composer install
```
###### Application setup
You must configure the database configuration in .env file

###### Generating SSH keys
``` 
openssl genrsa -out config/jwt/private.pem -aes256 4096
``` 

``` 
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
``` 

###### Application setup
``` 
php bin/console doctrine:schema:create
``` 
``` 
php bin/console app:init
``` 

### Versioning 

### Authors
* #####Aymen KOCHTI <kochti.aymen@gmail.com>
