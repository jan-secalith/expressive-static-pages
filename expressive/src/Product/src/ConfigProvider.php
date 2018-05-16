<?php

declare(strict_types=1);

namespace Product;

use Product\Handler\ProductListHandler;
use Product\Handler\ProductListHandlerFactory;
use Product\Service\ProductGateway;
use Product\Service\ProductGatewayFactory;
use Product\Service\ProductService;
use Product\Service\ProductServiceFactory;
use Product\Service\ProductTableService;
use Product\Service\ProductTableServiceFactory;
use Product\Model\ProductModel;
use Zend\Hydrator\ObjectProperty;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
            'app'          => $this->getAppConfig(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'factories'  => [
                ProductListHandler::class => ProductListHandlerFactory::class,
                ProductService::class => ProductServiceFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'product'    => [__DIR__ . '/../templates/product'],
            ],
        ];
    }

    public function getAppConfig()
    {
        return [
            'table_service' => [
                'Product\TableService' => [
                    'gateway' => [
                        'name' => 'Product\TableGateway',
                    ],
                ],
            ],
            'gateway' => [
                'Product\TableGateway' => [
                    'name' => 'Product\TableGateway',
                    'table' => [
                        'name' => 'product',
                        'object' => Model\ProductTable::class,
                    ],
                    'adapter' => [
                        'name' => 'Application\Db\LocalAdapter',
                    ],
                    'model' => [
                        "object" => Model\ProductModel::class,
                    ],
                    'hydrator' => [
                        "object" => \Common\Hydrator\CommonMapper::class,
                        'map' => [
                            'product_uid' => 'product_uid',
                            'name' => 'name',
                            'price' => 'price',
                            'unit' => 'unit',
                        ],
                    ],
                ],
            ],
        ];
    }
}
