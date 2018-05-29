

# PHP Checkout Application #

Author: Jan F Kowalski
Date:   April 2018

List of Content:
* About
* [General Notes](#anchor-g_notes)
* [Installation](#anchor-installation)
* [Frontend](#anchor-frontend)
* [Testing](#anchor-testing)
* [Development Mode](#anchor-development_mode)
* [VMbox](#anchor-vmbox)
* [Todo](#anchor-todo)

Developed on ubuntu/xenial (bento/ubuntu-16.04)

Author is Jan Franciszek Kowalski

### <a id="anchor-about" />About ###
Application for displaying static HTML Pages. If development mode is disabled the the requested Handler (Controller) output
should be cached into flat *.html file and read from there.



### <a id="anchor-g_notes" />General notes ###

The application is based on zend-expressive-skeleton in `Zend-Expressive v3` flavour and follows zend-framework module structure.

Application is written in PHP 7.2. This README is written wit intention for use with VM attached.
There may be no problem with running the application on the previous versions of PHP (<7.2). The Development been done
 in `bento/Ubuintu` environment.

Detailed information about the stack maybe found in `./Vagrantfile`


### <a id="anchor-installation" />Installation ###

To download the libraries with [composer](https://getcomposer.org/download/) run `composer install` from `./build`. the packages will be deployed to the `./application/vendor` directory.

The frontend assets may be compiled by running command `gulp` from `./build`

To install manually:
* create db, fill the pre-config (`./build.config/credentials.yml`) with db credentials, run `php ./build/bin/populate.db-credentials.php`
* run `composer install` from `./build`
* run `yarn` from `./build`
* run `composer install` from `./application`
* open your web instance in the browser [VM address](htttp://localhost:8088)

For some reason the gulp needs to be run twice to compile the assets. For that reason I left the *assets* compield in the public directory.

The zend-expressive installer does not accept package choice using print, for that reason i left the `./application/` in the package. Normally it should be deployed with the `composer install project`.

### <a id="anchor-frontend" />Frontend ###

There is Node, npm, yarn and gulp flow. The `package.json` inside the `./build/` directory is prepared for the *scripts* and *styles*. The assets gets compiled into `./application/public/assets/`

Modules used are Bootstrap3, jquery, bootstrap-multiselect. The frontend styles use sass framework. To change page styles edit those from `./build/src/assets/styles/styles.scss`

To run the compilation from the VM run `cd /var/www/build && gulp`.

#### <a id="anchor-development_mode" />Development Mode #####


To enable development mode you will ned to run `composer run-script development-enable` inside the `./application/` directory.

That should switch the cache off.

#### Testing ####
run unit test from `./expressive` using `composer test` command.

### <a id="anchor-vmbox" />VMbox ###
TIP: If using as VM it is best to run on host-machine with SSD.

To run the VM will need to install [Virtualbox](https://www.virtualbox.org/wiki/Downloads) and [Vagrant](https://www.vagrantup.com/downloads.html) installed.

There is php-7.2 and composer installed.

To access the site, after `vagrant up` open `http://127.0.0.1:8089` in your browser

#### <a id="anchor-todo" />TASKS TODO ####
* Flash Messages
* Memcache
* Twig

# RESTABLE ADMIN #
To create new submodule follow these steps 

*LIST*
* Create entry in the config/routes.php
* in modules configProvider add entry to app/handler/{RestableAdmin\Handler\CRUD\CreateHandler}/route/<routeName>/get