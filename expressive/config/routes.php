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
    $app->get('/stock[/{page:\d+}]', [
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
    # SCAN IN
    $app->get('/stock/scan/in[/]', [
        Stock\Handler\ScanInHandler::class
    ], 'stock.scan.in');
    $app->post('/stock/scan/in[/]', [
        Stock\Handler\ScanInHandler::class
    ], 'stock.scan.in.post');
    #SCAN OUT
    $app->get('/stock/scan/out', [
        Stock\Handler\StockListHandler::class
    ], 'stock.scan.out');

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

    $app->get('/restable/pages/privacy-policy', [
        Common\Middleware\StaticPageHandlerCacheMiddleware::class,
        Common\Handler\StaticPageHandler::class,
    ], 'restable.site.page.privacy_policy');

    $app->get('/restable/pages/request-demo', RestableSite\StaticPages\Handler\RequestDemoPageHandler::class, 'restable.site.page.request_demo');
    $app->post('/restable/pages/request-demo', RestableSite\StaticPages\Handler\RequestDemoPageHandler::class, 'restable.site.page.request_demo.post');

};
