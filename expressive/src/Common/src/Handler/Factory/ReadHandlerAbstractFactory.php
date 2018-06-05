<?php

declare(strict_types=1);

namespace Common\Handler\Factory;

use Common\Handler\DataAwareInterface;
use Common\Handler\ReadHandler;
use Common\Helper\CurrentRouteNameHelper;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Paginator\Paginator;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ReadHandlerAbstractFactory implements AbstractFactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return $this->createServiceWithName($container, $requestedName, $requestedName);
    }

    public function canCreate(\Interop\Container\ContainerInterface $container, $requestedName)
    {
        return $this->canCreateServiceWithName($container, $requestedName, $requestedName);
    }

    public function canCreateServiceWithName(
        ServiceLocatorInterface $serviceLocator, $name, $requestedName
    )
    {
        if (fnmatch("*\ReadHandler", $requestedName) && ! class_exists($requestedName)) {
            $config = $serviceLocator->get('config');
            if(array_key_exists('app',$config)
                && array_key_exists('handler',$config['app'])
                && array_key_exists($requestedName,$config['app']['handler'])
            ) {
                $handlerConfig = $config['app']['handler'][$requestedName];
                $routeName = $serviceLocator->get(CurrentRouteNameHelper::class)->getMatchedRouteName();

                if(array_key_exists($routeName,$handlerConfig['route'])) {
                    return true;
                }
            }
        }
        return false;
    }

    public function createServiceWithName(
        ServiceLocatorInterface $serviceLocator, $name, $requestedName
    ) {
        if ( ! class_exists($requestedName)) {

            $config = $serviceLocator->get('config');
            $handlerConfig = $config['app']['handler'][$name];

            $routeName = $serviceLocator->get(CurrentRouteNameHelper::class)->getMatchedRouteName();
            $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);

            $router   = $serviceLocator->get(RouterInterface::class);
            $template = $serviceLocator->has(TemplateRendererInterface::class)
                ? $serviceLocator->get(TemplateRendererInterface::class)
                : null;

            $urlHelper = $serviceLocator->get(UrlHelper::class);

            $resources = [];

            if(array_key_exists($routeName,$handlerConfig['route'])){
                    if(array_key_exists($requestMethod,$handlerConfig['route'][$routeName])) {

                        $routeConfig = $handlerConfig['route'][$routeName][$requestMethod];

                        if( array_key_exists('data_template_model',$routeConfig) ) {
                            if(array_key_exists('main',$routeConfig['data_template_model'])) {
                                foreach($routeConfig['data_template_model']['main'] as $mainContentDeclaration) {
                                    if(array_key_exists('read',$mainContentDeclaration)) {
                                        foreach($mainContentDeclaration['read'] as $fieldsetConfig) {
                                            if(array_key_exists('service',$fieldsetConfig)) {
                                                foreach($fieldsetConfig['service'] as $serviceConfig) {
                                                    if($serviceLocator->has($serviceConfig['service_name'])) {
                                                        $requestedService = $serviceLocator->get($serviceConfig['service_name']);
                                                        if(method_exists($requestedService,$serviceConfig['method'])) {
                                                            if(array('arguments',$serviceConfig)) {
                                                                foreach($serviceConfig['arguments'] as $arg) {
                                                                    if($arg['type'] == 'service') {
                                                                        if($serviceLocator->has($arg['service_name'])) {
                                                                            $argService = $serviceLocator->get($arg['service_name']);
                                                                            $argVal[] = $argService->{$arg['method']}($arg['arg_name']);
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            $resources[$fieldsetConfig['fieldset_name']]['data'] = $requestedService->{$serviceConfig['method']}($argVal[0]);
                                                            $resources[$fieldsetConfig['fieldset_name']]['service_config'] = $fieldsetConfig;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }

//                        var_dump($resources);

                        //

                        $targetClass = new ReadHandler(
                            $router,
                            $template,
                            get_class($serviceLocator),
                            $resources,
                            $urlHelper
                        );

                        // set LAYOUT and TEMPLATE
                        if(array_key_exists('view_template_model',$routeConfig) && $targetClass instanceof DataAwareInterface) {
                            $targetClass->addData($routeConfig['view_template_model'],'view_template_model');
                            if(array_key_exists('layout',$routeConfig['view_template_model'])) {
                                $targetClass->addData($routeConfig['view_template_model']['layout'],'layout');
                            }
                            if(array_key_exists('template',$routeConfig['view_template_model'])) {
                                $targetClass->addData($routeConfig['view_template_model']['template'],'template');
                            }
                        }
                        // set DATA-TABLE
                        if(array_key_exists('data_template_model',$routeConfig) && $targetClass instanceof DataAwareInterface) {
//                            if(array_key_exists('table',$routeConfig['data_template_model'])) {
                                $targetClass->addData($routeConfig['data_template_model'],'data_template_model');
//                            }
                        }

                        return $targetClass;
                    }
            }
        }

        return false;
    }
}
