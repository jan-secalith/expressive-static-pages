<?php

declare(strict_types=1);

namespace Common\Handler;

//use Psr\Container\ContainerInterface;
use Interop\Container\ContainerInterface;
use PHPUnit\Runner\Exception;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;
use Common\Model\StaticPageViewModel;
use Common\Handler\StaticPageHandler;

class StaticPageHandlerFactory
{

    private $module_name;

    public function __construct()
    {
        $this->module_name = "static_pages";
    }

    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {

        $router   = $container->get(RouterInterface::class);
        $template = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;
        $urlHelper = $container->get(UrlHelper::class);
        $dbCacheService = $container->get('memcached');
        $currentRouteName = $container->get(\Common\Helper\CurrentRouteNameHelper::class)->getMatchedRouteName();

        $config = $container->has('config') ? $container->get('config') : [];
        if( is_array($config)
            && array_key_exists('app',$config)
            && array_key_exists('route',$config['app'])
            && array_key_exists($currentRouteName,$config['app']['route'])
            && array_key_exists('module',$config['app']['route'][$currentRouteName])
            && array_key_exists($this->module_name,$config['app']['route'][$currentRouteName]['module'])
        ) {
            $routeModuleConfig = $config['app']['route'][$currentRouteName]['module'][$this->module_name];

            $viewTemplateModel = new StaticPageViewModel($routeModuleConfig['view_template_model']);

            return new StaticPageHandler(
                $router,
                $template,
                get_class($container),
                $urlHelper,
                $viewTemplateModel,
                $dbCacheService
            );
        } else {
            throw new Exception(sprintf("The Applications` configuration is not set for route %s module %s.",$currentRouteName,$this->module_name));
        }
    }
}
