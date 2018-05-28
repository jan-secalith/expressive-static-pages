<?php

declare(strict_types=1);

namespace Stock\Service\Factory;

use Stock\Service\StockService;
use Psr\Container\ContainerInterface;

class StockServiceFactory
{
    public function __invoke(ContainerInterface $container, $requestedName = null)
    {

        $stockTable = $container->get("Stock\TableService");
        $productTable = $container->get("Product\TableService");
        $stockBarcodeTable = $container->get("Stock\Barcode\TableService");
        $stockStatusTable = $container->get("Stock\Status\TableService");

        $cacheService = $container->get('memcached');

        // Load service-specific config
        $config = $container->get('config');
        if( array_key_exists('app',$config)
            && array_key_exists('module',$config['app'])
            && array_key_exists('stock',$config['app']['module'])
            && array_key_exists('service',$config['app']['module']['stock'])
            && array_key_exists(StockService::class,$config['app']['module']['stock']['service'])
        ) {
            $configStockService = $config['app']['module']['stock']['service'][StockService::class];
        } else {
            $configStockService = [];
        }

        return new StockService(
            $stockTable,
            $productTable,
            $stockStatusTable,
            $stockBarcodeTable,
            $cacheService,
            $configStockService
        );
    }
}
