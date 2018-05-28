<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;

/**
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Handler\HomePageHandler::class, 'home');
 * $app->post('/album', App\Handler\AlbumCreateHandler::class, 'album.create');
 * $app->put('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.put');
 * $app->patch('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.patch');
 * $app->delete('/album/:id', App\Handler\AlbumDeleteHandler::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Handler\ContactHandler::class,
 *     Zend\Expressive\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */
return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {

## STOCK: ##
    # INDEX
    $app->get('/stock[/[{page:\d+}]]', [
        Stock\Handler\StockListHandler::class
    ], 'stock.product.list');
    $app->post('/stock[/]', [
        Stock\Handler\SearchBarcodeHandler::class
    ], 'stock.product.list.post');
    # DETAILS:
    $app->get('/stock/details/{product_uid}', [
        Stock\Handler\StockDetailsHandler::class
    ], 'stock.product.details');
    # CREATE:
    $app->get('/stock/create[/]', [
        Stock\Handler\StockWriteHandler::class
    ], 'stock.product.write.create');
    $app->post('/stock/create[/]', [
        Stock\Handler\StockWriteHandler::class
    ], 'stock.product.write.create.post');
    # UPDATE:
    $app->get('/stock/update/{product_uid}', [
        Stock\Handler\StockWriteHandler::class
    ], 'stock.product.write.update');
    $app->post('/stock/update/{product_uid}', [
        Stock\Handler\StockWriteHandler::class
    ], 'stock.product.write.update.post');
    # DELETE:
    $app->get('/stock/remove/{product_uid}', [
        Stock\Handler\StockRemoveHandler::class
    ], 'stock.product.write.remove');
    $app->post('/stock/remove/{product_uid}', [
        Stock\Handler\StockRemoveHandler::class
    ], 'stock.product.write.remove.post');
    # SCAN IN
    $app->get('/stock/scan/in[/]', [
        Stock\Handler\ScanInHandler::class
    ], 'stock.scan.in');
    $app->post('/stock/scan/in[/]', [
        Stock\Handler\ScanInHandler::class
    ], 'stock.scan.in.post');
    # SCAN OUT
    $app->get('/stock/scan/out', [
        Stock\Handler\StockListHandler::class
    ], 'stock.scan.out');
    # SEARCH
    $app->get('/stock/search[/]', [
        Stock\Handler\StockSearchHandler::class
    ], 'stock.search');
    $app->post('/stock/search[/]', [
        Stock\Handler\StockSearchHandler::class
    ], 'stock.search.post');
## PRODUCTS


## THE RESTABLE WEBSITE: ##
    # LANDING PAGES:
    $app->get('/', [
        Common\Middleware\StaticPageHandlerCacheMiddleware::class,
        Common\Handler\StaticPageHandler::class,
    ], 'home');
    $app->get('/restable/pages/pricing', [
        Common\Middleware\StaticPageHandlerCacheMiddleware::class,
        Common\Handler\StaticPageHandler::class,
    ], 'restable.site.page.pricing');
    $app->get('/restable/pages/features', [
        Common\Middleware\StaticPageHandlerCacheMiddleware::class,
        Common\Handler\StaticPageHandler::class,
    ], 'restable.site.page.features');
    $app->get('/restable/pages/features/point-of-sale', [
        Common\Middleware\StaticPageHandlerCacheMiddleware::class,
        Common\Handler\StaticPageHandler::class,
    ], 'restable.site.page.features.pos');
    $app->get('/restable/pages/features/stock-monitoring', [
        Common\Middleware\StaticPageHandlerCacheMiddleware::class,
        Common\Handler\StaticPageHandler::class,
    ], 'restable.site.page.features.stock');
    $app->get('/restable/pages/privacy-policy', [
        Common\Middleware\StaticPageHandlerCacheMiddleware::class,
        Common\Handler\StaticPageHandler::class,
    ], 'restable.site.page.privacy_policy');
    $app->get('/restable/pages/request-demo', RestableSite\StaticPages\Handler\RequestDemoPageHandler::class, 'restable.site.page.request_demo');
    $app->post('/restable/pages/request-demo', RestableSite\StaticPages\Handler\RequestDemoPageHandler::class, 'restable.site.page.request_demo.post');


## RESTABLE ADMIN ##
    # LOGIN #
    $app->get('/admin/sign-in[/]', [
        RestableAdmin\Handler\AuthLoginHandler::class,
    ], 'restable.admin.auth.login');
    $app->post('/admin/sign-in[/]', [
        RestableAdmin\Handler\AuthLoginHandler::class,
    ], 'restable.admin.auth.login.post');
    # LOGOUT #
    $app->get('/admin/sing-out[/]', [
        RestableAdmin\Handler\AuthLogoutHandler::class,
    ], 'restable.admin.auth.logout');
    # SITE FORMS #
    $app->get('/admin/demo-enquiries[/[{page:\d+}]]', [
        'RestableAdmin\Handler\CRUD\ListHandler',
    ], 'restable.admin.requests.demo');

    # ADMIN DASHBOARD #
    $app->get('/admin/dashboard[/]', [
        'RestableAdmin\Handler\CRUD\ListHandler',
    ], 'restable.admin.dashboard');

    $app->get('/admin/orders/list[/[{page:\d+}]]', [
        'RestableAdmin\Handler\CRUD\ListHandler',
    ], 'restable.admin.orders.list');
    $app->get('/admin/products/list[/[{page:\d+}]]', [
        'RestableAdmin\Handler\CRUD\ListHandler',
    ], 'restable.admin.products.list');
    $app->get('/admin/stock/list[/[{page:\d+}]]', [
        'RestableAdmin\Handler\CRUD\ListHandler',
    ], 'restable.admin.stock.list');
    $app->get('/admin/stock/product/list[/[{page:\d+}]]', [
        'RestableAdmin\Handler\CRUD\ListHandler',
    ], 'restable.admin.stock_product.list');

    # APPLICATION #
    $app->get('/admin/applications/list[/[{page:\d+}]]', [
        'RestableAdmin\Handler\CRUD\ListHandler',
    ], 'restable.admin.application.list');
    # CREATE APPLICATION #
    $app->get('/admin/applications/create[/]', [
        'RestableAdmin\Handler\CRUD\CreateHandler',
    ], 'restable.admin.application.create');
    $app->post('/admin/applications/create[/]', [
        'RestableAdmin\Handler\CRUD\CreateHandler',
    ], 'restable.admin.application.create.post');

    # CLIENTS #
    $app->get('/admin/clients/list[/[{page:\d+}]]', [
        'RestableAdmin\Handler\CRUD\ListHandler',
    ], 'restable.admin.client.list');
    # CREATE CLIENT #
    $app->get('/admin/clients/create[/]', [
        'RestableAdmin\Handler\CRUD\CreateHandler',
    ], 'restable.admin.client.create');
    $app->post('/admin/clients/create[/]', [
        'RestableAdmin\Handler\CRUD\CreateHandler',
    ], 'restable.admin.client.create.post');
    # READ CLIENT #
    $app->get('/admin/client/details/{client_uid}', [
        'RestableAdmin\Handler\CRUD\ReadHandler',
    ], 'restable.admin.client.read');

    $app->get('/admin/application-clients/list[/[{page:\d+}]]', [
        'RestableAdmin\Handler\CRUD\ListHandler',
    ], 'restable.admin.application_client.list');
    $app->get('/admin/venues/list[/[{page:\d+}]]', [
        'RestableAdmin\Handler\CRUD\ListHandler',
    ], 'restable.admin.venue.list');

    # CATEGORY #
    $app->get('/admin/categories/list[/[{page:\d+}]]', [
        'RestableAdmin\Handler\CRUD\ListHandler',
    ], 'restable.admin.category.list');
    # CREATE CATEGORY #
    $app->get('/admin/categories/create[/]', [
        'RestableAdmin\Handler\CRUD\CreateHandler',
    ], 'restable.admin.category.create');
    $app->post('/admin/categories/create[/]', [
        'RestableAdmin\Handler\CRUD\CreateHandler',
    ], 'restable.admin.category.create.post');
    # READ CATEGORY #
    $app->get('/admin/categories/details/{category_uid}', [
        'RestableAdmin\Handler\CRUD\CreateHandler',
    ], 'restable.admin.category.read');

    # CONTACT #
    $app->get('/admin/contact/list[/[{page:\d+}]]', [
        'RestableAdmin\Handler\CRUD\ListHandler',
    ], 'restable.admin.contact.list');
    # CREATE CONTACT #
    $app->get('/admin/contact/create[/]', [
        'RestableAdmin\Handler\CRUD\CreateHandler',
    ], 'restable.admin.contact.create');
    $app->post('/admin/contact/create[/]', [
        'RestableAdmin\Handler\CRUD\CreateHandler',
    ], 'restable.admin.contact.create.post');
    # READ CONTACT #
    $app->get('/admin/contact/details/{contact_uid}', [
        'RestableAdmin\Handler\CRUD\ReadHandler',
    ], 'restable.admin.contact.read');

    # ADDRESS #
    $app->get('/admin/address/list[/[{page:\d+}]]', [
        'RestableAdmin\Handler\CRUD\ListHandler',
    ], 'restable.admin.address.list');
    # CREATE ADDRESS #
    $app->get('/admin/address/create[/]', [
        'RestableAdmin\Handler\CRUD\CreateHandler',
    ], 'restable.admin.address.create');
    $app->post('/admin/address/create[/]', [
        'RestableAdmin\Handler\CRUD\CreateHandler',
    ], 'restable.admin.address.create.post');
    # READ ADDRESS #
    $app->get('/admin/address/details/{address_uid}', [
        'RestableAdmin\Handler\CRUD\CreateHandler',
    ], 'restable.admin.address.read');

};
