# BabyLab.info
babylab.info website

## General Requirements
* PHP >= 7.2
* Composer - [Install](https://getcomposer.org/download/)

## Local Development Requirements
* VirtualBox - [Install](https://www.virtualbox.org/wiki/Downloads)
* Vagrant - [Install](https://www.vagrantup.com/downloads.html)
* Node.js - [Install](https://nodejs.org/en/download/)

## Local Development Notes
* Run `npm install` from the local laravel directory on your OS to get the required modules.
* Run  `npm run watch` to get the latest changes on your compiled css file.
* If you are using `artisan`, remember to run `php artisan` from the Laravel directory on your Virtual Machine (`vagrant ssh` and navigate to `/var/www/laravel/`).
* Don't forget to setup your `/var/www/laravel/.env` file the first time you deploy.