<?php

declare(strict_types=1);

namespace Stock;

use Stock\Hydrator\ProductStockMapper;
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
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'factories'  => [
                Handler\ScanBarcodeInHandler::class => Handler\ScanBarcodeInHandlerFactory::class,
                Handler\ProductListHandler::class => Handler\ProductListHandlerFactory::class,
                Handler\SearchBarcodeHandler::class => Handler\SearchBarcodeHandlerFactory::class,
                Service\StockService::class => Service\StockServiceFactory::class,
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
                        "object" => Model\ProductStockModel::class,
                    ],
                    'hydrator' => [
                        "object" => Hydrator\ProductStockMapper::class,
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
            ],
            'route' => [
                'stock.product.list' => [
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
        ];
    }

}
