<?php

declare(strict_types=1);

namespace Stock\Handler;

use Product\Service\ProductService;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Stock\Service\StockService;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class ScanBarcodeInHandlerFactory
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

        return new ScanBarcodeInHandler(
            $router,
            $template,
            get_class($container),
            $productService,
            $stockService,
            $urlHelper
        );
    }
}
