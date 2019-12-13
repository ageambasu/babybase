# BabyLab.info
babylab.info website

## General Requirements
* PHP >= 7.2
* Composer - [Install](https://getcomposer.org/download/)
* MySQL - [Install](https://www.mysql.com/downloads/)
* Node.js - [Install](https://nodejs.org/en/download/)
* Git - [Install](https://git-scm.com/downloads)

## Local Development Requirements
* VirtualBox - [Install](https://www.virtualbox.org/wiki/Downloads)
* Vagrant - [Install](https://www.vagrantup.com/downloads.html)

## Local Development Notes
* Don't forget to setup your `/var/www/laravel/.env` file.
* Run `composer install` from the local laravel directory on your OS to get the required vendors.
* Run `npm install` from the local laravel directory on your OS to get the required modules.
* Run  `npm run watch` to get the latest changes on your compiled css file.
* If you are using `artisan`, remember to run `php artisan` from the Laravel directory on your VM (`vagrant ssh` then navigate to `/var/www/laravel/`).

## Deployment Notes
* Don't forget to setup your production `.env` file.
* Run `composer install` from the laravel directory on your server to get the required vendors.
* Run `npm install` from the laravel directory on your server to get the required modules.
* You may need to run `php artisan key:generate` from the laravel directory on your server.
* Don't forget to link your server's public folder to `babylab/laravel/public`.
* Create a `babylab` database and store the credentials on your `.env`.
* Run `php artisan migrate` from the laravel directory on your server to get all the tables on your database.