<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

## SampleCode

SampleCode

## Installation

### Clone repo

``` bash
# clone the repo
$ git clone https://github.com/arsalanqayum/sample-code-example.git

# go into app's directory
$ cd to-project

# install app's dependencies
$ composer install or update

# Setup .env file as per your local server
$ cp .env.example .env

# Run migrations
$ php artisan migrate

# Run seeders
$ php artisan db:seed
```


## Usage

``` bash
# Recommended: you can set up virtual host on your local machine or 

# serve at localhost:8080
php artisan serve

```

## Setup cron job on local

``` bash
# Cron job handle buyer sample code termination and allocation process as per defined in the project requirment docuemnt.
# LAMP Server - Linix - Ubuntu

# Run
crontab -e
# Insert Following line and save it
* * * * * cd /path/to/project/root/ && php artisan schedule:run >> /dev/null 2>&1
```

## API Docs
- [Postman API documentation](Can provide sample on request).

