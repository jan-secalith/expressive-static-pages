

# Static Pages Application [Dev] #
## based on Zend expressive Skeleton Application ##
Date:   April 2018

List of Content:
* [Installation](#anchor-installation)
* [General Notes](#anchor-g_notes)
* [Database](#anchor-database)
* [Frontend](#anchor-frontend)
* [Forms] TODO
* [Testing](#anchor-testing)
* [Development Mode](#anchor-development_mode)
* [VMbox](#anchor-vmbox)
* [Todo](#anchor-todo)

Simple application which purpose is to deliver simple application composed in zend-expressive. At its current version itdisplay static content.

It also has Form submission functionality and saves data to local sqlite database. There are migrations written in phinx inside `./build/data/db/` .
The Form submission page is not cached due to security, otherwise it would use inalid CSRF token. This subject is covered in [Symofony Docs](https://symfony.com/doc/current/http_cache/form_csrf_caching.html).
After some consideration I think it would be best to use ajax for form loading (response without layout) and submission. Such solution also would enhance enduser experience.

@todo: memcache in VM

### <a id="anchor-g_notes" />General notes ###

The application is based on zend-expressive-skeleton and `Zend-Expressive v2` and follows zend-framework module structure.
The approach taken should make it fairly easy to tranform the Project to work with `Zend-Expressive v3` 

Application is written in PHP 7.2, Mysql 5.7 This README is written for use with VM attached. The Development been done in `bento/Ubuntu` environment.

Detailed information about the development stack maybe found in `./Vagrantfile`

### <a id="anchor-installation" />Installation ###

To download the libraries with [composer](https://getcomposer.org/download/) run `composer install` from `./build`. the packages will be deployed to the `./application/vendor` directory.

The frontend assets may be compiled by running command `gulp` from `./build`

To install manually:
* ??run `composer install` from `./build`
* run `yarn` from `./build`
* run `composer install` from `./application`
* open your web instance in the browser [VM address](htttp://localhost:8088)

For some reason the gulp needs to be run twice to compile the assets. For that reason I left the *assets* compield in the public directory.

The zend-expressive installer does not accept package choice using print, for that reason i left the `./application/` in the package. Normally it should be deployed with the `composer install project`.

### <a id="anchor-frontend" />Frontend ###

There is Node, npm, yarn and gulp flow. The `package.json` inside the `./build/` directory is prepared for the *scripts* and *styles*. The assets gets compiled into `./application/public/assets/`

Modules used are Bootstrap3, jquery, bootstrap-multiselect. The frontend styles use sass framework. To change page styles edit those from `./build/src/assets/styles/styles.scss`

To run the compilation from the VM run `cd /var/www/build && gulp`.

### <a id="anchor-database" />Database ###
Uses Mysql 5.7. The credentials may be set in `./application/config/autoload/zend-db.local.php`

If using the installation script, place your credentials in `./build/config/credentials.yml`

For database Queries zend-db is used. Did not want to over-complicate with Doctrrine, this project is too small.

Database defauts:
* user: `root`
* password: `root`
* host: `localhost`
* dbname: `bjss_app`
* dumpfile: `./build/data/db/schema.sql`

There is Adminer accessible at [http://127.0.0.1:8088/adminer.php](http://127.0.0.1:8088/adminer.php)
If the link address returns 404 then run `vagrant ssh` and `sh ./build/bin/adminer.sh` and try to access the adminer again.again

### <a id="anchor-currencylayer" />Currencylayer API ###
If using the installation script then set your ApiKey in `./build/config/credentials.yml`

ApiKey may be changed in `./application/`

#### <a id="anchor-development_mode" />Development Mode #####
To enable development mode you will ned to run `composer run-script development-enable` inside the `./application/` directory.

#### Testing ####
run unit test from `./applciation` using `composer test` command.

### <a id="anchor-vmbox" />VMbox ###
TIP: If using as VM it is best to run on host-machine with SSD.

To run the VM will need to install [Virtualbox](https://www.virtualbox.org/wiki/Downloads) and [Vagrant](https://www.vagrantup.com/downloads.html) installed.

There is php-7.2 and mysql-server, xdebug and composer installed.

To access the site, after `vagrant up` open `http://127.0.0.1:8088` in your browser

#### <a id="anchor-todo" />TASKS TODO ####
* Flash Messages
* Cache
* Twig
* Build-front compilation
* write the application installer to generate application from fresh config
* documentation
* Form Validators
* fix xdebug, ppbly installs to the wrong php.ini
* cronjob to clean abandoned carts
* when creating new cart, check if id has not been used already
* export APP_ENV=development, actually not used
* POSTMAN and NEWMAN tests
* Custom error middleware
* event logging
* jsonrates request with etag (to save bandwidth)
* event manager
* forms csrf when expires should create flash message and redirect
* Create viewHelper for the cart to check if not empty
* currency `CurrencyExchange\Service\ApiClient` API Client should be done as adapter or interface
 * set locale
 
#### Future Improvements

* Refactor local source libraries to be available as composer packages


#### Cart / Checkout Study
#
* https://www.clickz.com/10-of-the-smoothest-ecommerce-checkouts-on-the-web/101588/
* https://baymard.com/blog/checkout-flow-average-forms-fields
* https://baymard.com/checkout-usability/methodology
* https://www.demandware.com/blog/retail-intelligence/ux-best-practices-checkout-flow