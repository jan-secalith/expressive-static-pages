<?php

declare(strict_types=1);

namespace Product\Service;

use Cart\Session\CartContainer;
use Cart\Service\CartService;
use Common\Helper\RouteHelper;
use Psr\Container\ContainerInterface;
use CurrencyExchange\Service\CurrencyExchangeService;
use Zend\Expressive\Helper\UrlHelper;

class ProductTableServiceFactory
{
    protected $identifier = "product";
    protected $requestedGateway = \Product\Service\ProductGateway::class;

    /**
     * @var \Product\Model\ProductTable
     */
    protected $requestedTable = \Product\Model\ProductTable::class;

    public function __invoke(ContainerInterface $container,$requestedName=null)
    {

        $routeTableGateway = $container->get($this->requestedGateway);

        $table = new $this->requestedTable($routeTableGateway);

        return $table;

    }
}
