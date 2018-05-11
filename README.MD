

# PHP Checkout Application #

Author: Jan F Kowalski
Date:   April 2018

List of Content:
* [Installation](#anchor-installation)
* [General Notes](#anchor-g_notes)
* [Frontend](#anchor-frontend)
* [Database](#anchor-database)
* [Currencylayer API](#anchor-currencylayer)
* [Forms] TODO
* [Testing](#anchor-testing)
* [Development Mode](#anchor-development_mode)
* [VMbox](#anchor-vmbox)
* [Todo](#anchor-todo)

Developed on ubuntu/xenial (bento/ubuntu-16.04)
https://docs.zendframework.com/zend-expressive/v2/features/error-handling/

### <a id="anchor-g_notes" />General notes ###

The application is based on zend-expressive-skeleton and `Zend-Expressive v2` and follows zend-framework module structure.
The approach taken should make it fairly easy to tranform the Project to work with `Zend-Expressive v3` 

Application is written in PHP 7.2, Mysql 5.7 This README is written for use with VM attached.
There should be no problem with running the application on the previous versions. The Development been done
 in `bento/Ubuintu` environment.

Author is Jan Franciszek Kowalski

The cart and its products are stored in database. I dont trust sessions enough to store such critical data.

For the specification of the assesment task the service jsonrates is integrated into `CurrencyExchange`  module.

After the *Purchase* id done the *Currency* and *sessionId* are reset. So the cart appears to be empty.
The *Cart* data is saved to DB. IN future version the Cart should be converted to the Order and also saved to DB.

Detailed information about the stack maybe found in `./Vagrantfile`

The configuration-driven pipeline approcah does not work for me. That may be something wrong with ZExpressive.
@todo investigate.

It is possible to use currency exchange rates with Cart Action. The property '$useCurrencyExchange' in `Cart\Action\CartListAction` does is set

To add new option to the cart
* declare it in `./application/src/Cart/ConfigProvider` index `module/cart/service/options` 
* depends on your hydrating method, set properties and methods`\Cart\Model\CartOptionsModel`. (required)

The the limitation per item in the cart may be changed by updating `product_qty` index in `\Cart\Form\ItemAddForm` and `\Cart\Form\ItemUpdateForm`
Database schema attached has the `tinyint(6)` set.

### <a id="anchor-installation" />Installation ###

Pre-set database credentials and apikeys in `./build/config/credentials.yml` and run  `php populate.db-credentials.php`
and `php populate.currency_exchange.api-credentials.php` respectively. Those scripts run also afted `composer install` command (more in composer.json).

To download the libraries with [composer](https://getcomposer.org/download/) run `composer install` from `./build`. the packages will be deployed to the `./application/vendor` directory.

The frontend assets may be compiled by running command `gulp` from `./build`

To install manually:
* create db, fill the pre-config (`./build.config/credentials.yml`) with db credentials, run `php ./build/bin/populate.db-credentials.php`
* jsonrates account, fill the pre-config (`./build.config/credentials.yml`) with api key, run `php ./build/bin/populate.currency_exchange.api-credentials.php`
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
* Phinx migrations
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