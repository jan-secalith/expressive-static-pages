<?php
namespace Stock\Service;

use Stock\Model\StockTable;
use Common\Helper\RouteHelper;
use Psr\Container\ContainerInterface;

class StockServiceFactory
{
    public function __invoke(ContainerInterface $container, $requestedName = null)
    {

//        $stockTable = $container->get("Stock\TableService");
        $stockTable = null;//$container->get("Stock\TableService");
//        $stockTable = $container->get(StockTable::class);
        $stockBarcodeTable = null;//$container->get(StockBarcodeTable::class);

        return new StockService($stockTable,$stockBarcodeTable);
    }
}
