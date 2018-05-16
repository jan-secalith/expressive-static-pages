<?php

declare(strict_types=1);

namespace Stock\Service;

use Stock\Model\StockBarcodeTable;
use Stock\Model\StockTable;
use Stock\Model\StockWriteModel;

/**
 * Class CartService
 *
 * Works in context of the session
 *
 * @package Cart\Service
 */
class StockService
{

    protected $stockTable;
    protected $stockBarcodeTable;

    public function __construct(StockTable $stockTable = null, StockBarcodeTable $stockBarcodeTable = null)
    {
        $this->stockTable = $stockTable;
        $this->stockBarcodeTable = $stockBarcodeTable;
    }

    public function getStockTable()
    {
        return $this->stockTable;
    }

    public function search($term)
    {
        return $this->stockBarcodeTable->getItem($term);
    }

    public function stockIncrease($stock_barcode,$stock_qty)
    {

    }

    public function getAllFull(){
        return $this->stockTable->fetchAllFull();
    }

    public function getItems()
    {
        $cartProducts = $this->stockTable->fetchAll();

        if (!empty($cartProducts)) {
            return $cartProducts;
        }

        return null;
    }

    public function getItem($productId)
    {
        return $this->stockTable->getItem($productId);
    }

    public function getByBarcode($barcode)
    {
        return $this->stockBarcodeTable->getItem($barcode);
    }

    public function addStockProduct(StockWriteModel $stockProductItem = null)
    {
        $productIncomingData = $stockProductItem->getFieldsetProduct();
        $stockIncomingData = $stockProductItem->getFieldsetStock();

        // determine if product already exists
//        if() {
//
//        }

//        var_dump($stockProductItem);
    }
}
