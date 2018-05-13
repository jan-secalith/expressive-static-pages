<?php

declare(strict_types=1);

namespace Stock\Handler;

use Product\Service\ProductService;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
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
        $urlHelper = $container->get(UrlHelper::class);

        return new SearchBarcodeHandler(
            $router,
            $template,
            get_class($container),
            $productService,
            $urlHelper
        );
    }
}
