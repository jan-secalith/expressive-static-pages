<?php

declare(strict_types=1);

namespace Stock\Service;

use Stock\Model\StockTable;
use Psr\Container\ContainerInterface;

class StockServiceFactory
{
    public function __invoke(ContainerInterface $container, $requestedName = null)
    {

        $stockTable = $container->get("Stock\TableService");
        $productTable = $container->get("Product\TableService");
        $stockBarcodeTable = $container->get("Stock\Barcode\TableService");

        return new StockService($stockTable,$productTable,$stockBarcodeTable);
    }
}
