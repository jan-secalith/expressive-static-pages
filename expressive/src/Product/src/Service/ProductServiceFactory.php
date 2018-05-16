<?php
namespace Product\Service;

use Product\Service\ProductTableService;
use Product\Service\ProductService;
use Cart\Session\CartContainer;
use Cart\Service\CartService;
use Common\Helper\RouteHelper;
use Psr\Container\ContainerInterface;
use CurrencyExchange\Service\CurrencyExchangeService;
use Zend\Expressive\Helper\UrlHelper;

class ProductServiceFactory
{
    public function __invoke(ContainerInterface $container, $requestedName = null)
    {

        $productTable = $container->get("Product\TableService");

        $cacheService = $container->get('memcached');

        return new ProductService(
            $productTable,
            $cacheService
        );

    }
}
