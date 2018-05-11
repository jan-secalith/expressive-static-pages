<?php

namespace Common\Service;

use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Psr\Container\ContainerInterface;

class GatewayAbstractFactory implements AbstractFactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null){
        return $this->createServiceWithName($container, $requestedName, $requestedName);
    }

    public function canCreate(\Interop\Container\ContainerInterface $container, $requestedName)
    {
        return $this->canCreateServiceWithName($container, $requestedName, $requestedName);
        // TODO: Implement canCreate() method.
    }

    public function canCreateServiceWithName(
        ServiceLocatorInterface $serviceLocator, $name, $requestedName
    ) {
        return (fnmatch('*PageAction', $requestedName));
    }

    public function createServiceWithName(
        ServiceLocatorInterface $serviceLocator, $name, $requestedName
    ) {
        if (class_exists($requestedName)) {
            $router   = $serviceLocator->get(RouterInterface::class);
            $template = ($serviceLocator->has(TemplateRendererInterface::class))
                ? $serviceLocator->get(TemplateRendererInterface::class)
                : null;

            switch ($requestedName) {
                case(\App\Action\AboutPageAction::class):
                case(\App\Action\ContactPageAction::class):
                    return new $requestedName($router, $template);
                    break;
            }

        }

        return false;
    }
}