<?php

declare(strict_types=1);

namespace Stock\Service;

use Stock\Service\StockService;

interface StockServiceAwareInterface
{

    public function setStockService(StockService $stockService);

    public function getStockService() : StockService;

}