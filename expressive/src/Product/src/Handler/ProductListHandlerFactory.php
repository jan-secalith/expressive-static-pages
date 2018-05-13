<?php

declare(strict_types=1);

namespace Product\Handler;

use Cart\Service\CartService;
use Product\Service\ProductService;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class ProductListHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $router   = $container->get(RouterInterface::class);
        $template = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;

        $productService = $container->get(ProductService::class);
        $cartService = ($container->has(CartService::class))?$container->get(CartService::class):null;
        $urlHelper = $container->get(UrlHelper::class);

        return new ProductListHandler(
            $router,
            $template,
            get_class($container),
            $productService,
            $cartService,
            $urlHelper
        );
    }
}
