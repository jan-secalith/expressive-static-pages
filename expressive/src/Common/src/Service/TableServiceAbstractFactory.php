<?php

declare(strict_types=1);

namespace Common\Service;

use Cart\Session\CartContainer;
use Cart\Service\CartService;
use Common\Helper\RouteHelper;
use Psr\Container\ContainerInterface;
use CurrencyExchange\Service\CurrencyExchangeService;
use Zend\Expressive\Helper\UrlHelper;

class TableServiceAbstractFactory
{
    protected $identifier = "cart_item";

    /**
     * @var \Cart\Model\CartTable
     */
    protected $requestedTable = \Cart\Model\CartItemTable::class;

    public function __invoke(ContainerInterface $container,$requestedName=null)
    {
        $config = $container->get('config');

        $requestedGateway = $config['app']['module'][$this->identifier]['gateway']['service']['object'];

        $requestedTable = $config['app']['module'][$this->identifier]['gateway']['table']['object'];

        $routeTableGateway = $container->get($requestedGateway);

        $table = new $requestedTable($routeTableGateway);

        return $table;
    }
}
