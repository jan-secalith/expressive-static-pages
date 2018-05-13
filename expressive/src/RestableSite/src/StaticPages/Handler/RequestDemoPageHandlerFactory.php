<?php

declare(strict_types=1);

namespace RestableSite\StaticPages\Handler;

use RestableSite\StaticPages\Handler\RequestDemoPageHandler;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class RequestDemoPageHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $router   = $container->get(RouterInterface::class);
        $template = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;
        $tableService = $container->get("RestableSite\StaticPages\RequestDemo\TableService");

        return new RequestDemoPageHandler(
            $router,
            $template,
            get_class($container),
            $tableService
        );
    }
}
