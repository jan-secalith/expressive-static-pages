<?php
namespace Product\Service;

use Product\Service\StockGateway;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Hydrator\ObjectProperty;

class ProductGatewayFactory
{
    protected $identifier = "product";

    protected $model = \Product\Model\ProductModel::class;

    public function __invoke($container, $requestedName = null, array $options = null)
    {
        $moduleConfig = $container->get("config");

        $dbAdapterName = $moduleConfig['app']['module'][$this->identifier]['gateway']['adapter'];
        $dbHydratorName = $moduleConfig['app']['module'][$this->identifier]['gateway']['hydrator']['object'];
        $modelName = $moduleConfig['app']['module'][$this->identifier]['gateway']['model']['object'];

        $dbAdapter = $container->get($dbAdapterName);
        $resultSet = new \Zend\Db\ResultSet\HydratingResultSet(
            new $dbHydratorName(),
            new $modelName()
        );

        return new StockGateway(
            $this->identifier,
            $dbAdapter,
            null,
            $resultSet
        );
    }
}
