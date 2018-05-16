<?php

declare(strict_types=1);

namespace Stock\Service;

use Stock\Service\StockService;

trait StockServiceAwareTrait
{
    protected $stockService;

    public function setStockService(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function getStockService() : StockService
    {
        return $this->stockService;
    }
}