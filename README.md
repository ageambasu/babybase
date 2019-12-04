# BabyLab.info
babylab.info website

## General Requirements
* PHP >= 7.2
* Composer - [Install](https://getcomposer.org/download/)

## Local Development Requirements
* VirtualBox - [Install](https://www.virtualbox.org/wiki/Downloads)
* Vagrant - [Install](https://www.vagrantup.com/downloads.html)

## Local development notes
* Run `npm install` from your local laravel directory to get all the required modules.
* Run  `npm run watch` to get the latest changes on your compiled css file.
* If you are using `artisan` for database migrations, remember to run `php artisan migrate` from the laravel directory on your VM (`vagrant ssh` and navigate to `/var/www/laravel/`) when migrating tables.