<?php

declare(strict_types=1);

namespace RestableAdmin\Handler\Factory;

use Product\Service\ProductService;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RestableAdmin\Handler\AuthLogoutHandler;
use Stock\Service\StockService;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class AuthLogoutHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $router   = $container->get(RouterInterface::class);
        $template = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;

        /* @var \Zend\Authentication\AuthenticationService $authService */
        $authService = null;//$container->get(\Zend\Authentication\AuthenticationService::class);
        $authManager = $container->get(\Authentication\Service\AuthManager::class);

        $urlHelper = $container->get(UrlHelper::class);

        return new AuthLogoutHandler (
            $router,
            $template,
            get_class($container),
            $authService,
            $authManager,
            $urlHelper
        );
    }
}
