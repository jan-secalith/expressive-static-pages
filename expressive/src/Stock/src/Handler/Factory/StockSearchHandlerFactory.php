<?php

declare(strict_types=1);

namespace Stock\Handler\Factory;

use Product\Service\ProductService;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Stock\Handler\StockListHandler;
use Stock\Handler\StockSearchHandler;
use Stock\Service\StockService;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Paginator\Paginator;

class StockSearchHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $router   = $container->get(RouterInterface::class);
        $template = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;

        $urlHelper = $container->get(UrlHelper::class);
        $productService = $container->get(ProductService::class);
        $stockService = $container->get(StockService::class);



        return new StockSearchHandler(
            $router,
            $template,
            get_class($container),
            $productService,
            $stockService,
            $urlHelper
        );
    }
}
