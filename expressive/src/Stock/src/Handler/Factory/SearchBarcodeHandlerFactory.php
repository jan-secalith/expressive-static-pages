<?php

declare(strict_types=1);

namespace Stock\Handler\Factory;

use Product\Service\ProductService;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Stock\Handler\SearchBarcodeHandler;
use Stock\Service\StockService;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class SearchBarcodeHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $router   = $container->get(RouterInterface::class);
        $template = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;
        $productService = $container->get(ProductService::class);
        $stockService = $container->get(StockService::class);
        $urlHelper = $container->get(UrlHelper::class);

        return new SearchBarcodeHandler(
            $router,
            $template,
            get_class($container),
            $productService,
            $stockService,
            $urlHelper
        );
    }
}
