<?php

declare(strict_types=1);

namespace Stock;

use Stock\Hydrator\ProductStockMapper;
use Whoops\Handler\Handler;
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
            'app'    => $this->getApplicationConfig(),
            'view_helpers'  => [
                'invokables' => [
                    'displayStockStatus' => View\Helper\StockStatusLabelHelper::class,
                ],
            ],
            'session_containers' => [
                'StockProductDelete'
            ],
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'factories'  => [
                \Stock\Handler\ScanInHandler::class => \Stock\Handler\Factory\ScanInHandlerFactory::class,
                \Stock\Handler\SearchBarcodeHandler::class => \Stock\Handler\Factory\SearchBarcodeHandlerFactory::class,
                \Stock\Handler\StockDetailsHandler::class => \Stock\Handler\Factory\StockDetailsHandlerFactory::class,
                \Stock\Handler\StockListHandler::class => \Stock\Handler\Factory\StockListHandlerFactory::class,
                \Stock\Handler\StockSearchHandler::class => \Stock\Handler\Factory\StockSearchHandlerFactory::class,
                \Stock\Handler\StockWriteHandler::class => \Stock\Handler\Factory\StockWriteHandlerFactory::class,
                \Stock\Handler\StockRemoveHandler::class => \Stock\Handler\Factory\StockRemoveHandlerFactory::class,
                \Stock\Service\StockService::class => \Stock\Service\Factory\StockServiceFactory::class,
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
                'stock'    => [__DIR__ . '/../templates/stock'],
                'stock-form'    => [__DIR__ . '/../templates/stock-form'],
            ],
        ];
    }

    public function getApplicationConfig()
    {
        return [
            'application' => [
                [
                    'application_id' => '2',
                    'application_name' => 'restablestock',
                ]
            ],
            'table_service' => [
                'Stock\TableService' => [
                    'gateway' => [
                        'name' => 'Stock\TableGateway',
                    ],
                ],
                'Stock\Barcode\TableService' => [
                    'gateway' => [
                        'name' => 'Stock\Barcode\TableGateway',
                    ],
                ],
                'Stock\Status\TableService' => [
                    'gateway' => [
                        'name' => 'Stock\Status\TableGateway',
                    ],
                ],
            ],
            'module' => [
                'stock' => [
                    'service' => [
                        'Stock\Service\StockService' => [
                            'remove_purge' => false,
                        ],
                    ],
                    'scenario' => [
                        #TODO implement
                        'create' => [],
                        'remove' => [],
                        'update' => [],
                        'delete' => [],
                        'export' => [],
                        'list' => [],
                        'import' => [],
                    ],

                ],
            ],
            'gateway' => [
                'Stock\TableGateway' => [
                    'name' => 'Stock\TableGateway',
                    'table' => [
                        'name' => 'stock',
                        'object' => Model\StockTable::class,
                    ],
                    'adapter' => [
                        'name' => 'Application\Db\LocalAdapter',
                    ],
                    'model' => [
                        "object" => Model\StockProductModel::class,
                    ],
                    'hydrator' => [
                        "object" => \Common\Hydrator\CommonMapper::class,
                        'map' => [
                            'stock_uid' => 'stock_uid',
                            'product_uid' => 'product_uid',
                            'product_qty' => 'product_qty',
                            'name' => 'name',
                            'price' => 'price',
                            'unit' => 'unit',
                            'barcodes' => 'barcodes',
                            'updated' => 'updated',
                            'created' => 'created',
                        ],
                    ],
                ],
                'Stock\Barcode\TableGateway' => [
                    'name' => 'Stock\BarcodeTableGateway',
                    'table' => [
                        'name' => 'stock_barcode',
                        'object' => Model\StockBarcodeTable::class,
                    ],
                    'adapter' => [
                        'name' => 'Application\Db\LocalAdapter',
                    ],
                    'model' => [
                        "object" => Model\StockBarcodeModel::class,
                    ],
                    'hydrator' => [
                        "object" => ObjectProperty::class,
                    ],
                ],
                'Stock\Status\TableGateway' => [
                    'name' => 'Stock\StatusTableGateway',
                    'table' => [
                        'name' => 'stock_status',
                        'object' => Model\StockStatusTable::class,
                    ],
                    'adapter' => [
                        'name' => 'Application\Db\LocalAdapter',
                    ],
                    'model' => [
                        "object" => Model\StockStatusModel::class,
                    ],
                    'hydrator' => [
                        "object" => ObjectProperty::class,
                    ],
                ],
            ],
            'route' => [
                'stock.product.list' => [
                    'get' => [
                        'method' => 'GET',
                        'scenario' => 'list',
                        'cache_response' => [
                            'enabled' => false,
                        ],
                        'module' => [
                            'stock' => [
                                'view_template_model' => [
                                    'layout' => 'restablesite-layout::restable-site',
                                    'template' => 'staticpages::page-homepage-2018',
                                ],
                            ],
                        ],
                    ],
                ],
                'stock.product.details' => [
                    'get' => [
                        'method' => 'GET',
                        'scenario' => 'details',
                        'cache_response' => [
                            'enabled' => false,
                        ],
                        'module' => [
                            'stock' => [
                                'view_template_model' => [
                                    'layout' => 'restable-stock-layout::restable-stock',
                                    'template' => 'stock::stock-product-write',
                                ],
                            ],
                        ],
                    ],
                ],
                'stock.product.write.update.post' => 'stock.product.write.update',
                'stock.product.write.update' => [
                    'get' => [
                        'method' => 'GET',
                        'scenario' => 'update',
                        'cache_response' => [
                            'enabled' => false,
                        ],
                        'module' => [
                            'stock' => [
                                'view_template_model' => [
                                    'layout' => 'restable-stock-layout::restable-stock',
                                    'template' => 'stock::stock-product-write',
                                ],
                            ],
                        ],
                    ],
                    'post' => [
                        'method' => 'GET',
                        'cache_response' => [
                            'enabled' => false,
                        ],
                        'module' => [
                            'stock' => [
                                'redirect' => [
                                    'success' => [
                                        'route_name' => 'stock.product.details'
                                    ],
                                ],
                                'view_template_model' => [
                                    'layout' => 'restable-stock-layout::restable-stock',
                                    'template' => 'stock::stock-product-write',
                                ],
                            ],
                        ],
                    ],

                ],
            ],
        ];
    }

}
