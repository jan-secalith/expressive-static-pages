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
    $app->get('/', App\Handler\HomePageHandler::class, 'home');
//    $app->get('/api/ping', App\Handler\PingHandler::class, 'api.ping');

## THE RESTABLE WEBSITE: ##

    # LANDING PAGES:
    $app->get('/restable/pages/pricing', [
        Common\Middleware\StaticPageHandlerCacheMiddleware::class,
        Common\Handler\StaticPageHandler::class,
    ], 'restable.site.page.pricing');
    $app->get('/restable/pages/features', [
        Common\Middleware\StaticPageHandlerCacheMiddleware::class,
        Common\Handler\StaticPageHandler::class,
    ], 'restable.site.page.features');
    $app->get('/restable/pages/request-demo', RestableSite\StaticPages\Handler\RequestDemoPageHandler::class, 'restable.site.page.request_demo');
    $app->post('/restable/pages/request-demo', RestableSite\StaticPages\Handler\RequestDemoPageHandler::class, 'restable.site.page.request_demo.post');

};
