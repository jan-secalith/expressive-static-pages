<?php

declare(strict_types=1);

namespace Stock\Service;

use Product\Model\ProductTable;
use Stock\Model\StockBarcodeTable;
use Stock\Model\StockTable;
use Stock\Model\StockWriteModel;

class StockService
{

    /**
     * @var StockTable
     */
    protected $stockTable;

    /**
     * @var ProductTable
     */
    protected $productTable;

    /**
     * @var StockBarcodeTable
     */
    protected $stockBarcodeTable;

    public function __construct(
        StockTable $stockTable = null,
        ProductTable $productTable = null,
        StockBarcodeTable $stockBarcodeTable = null
    )
    {
        $this->stockTable = $stockTable;
        $this->productTable = $productTable;
        $this->stockBarcodeTable = $stockBarcodeTable;
    }

    /**
     * @return StockTable
     */
    public function getStockTable()
    {
        return $this->stockTable;
    }

    /**
     * @return ProductTable
     */
    public function getProductTable()
    {
        return $this->productTable;
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
        $productRowsAffected = 0;
        $stockRowsAffected = 0;

        // determine if product already exists
        if($this->getProductTable()->getItemCount($productIncomingData->getProductUid())>0) {
            // Determine if Product data has changed
            $productDbData = $this->getProductTable()->getItem($productIncomingData->getProductUid());
            $diffProduct = array_diff($productIncomingData->toArray(),$productDbData->toArray());
            if( ! empty($diffProduct) ) {
                $productRowsAffected = $this->getProductTable()->updateItem($productDbData->getProductUid(),$diffProduct);
            }
            // Determine if Stock has been changed
            if($this->stockTable->getItemCount($stockIncomingData->getProductUid())>0) {
                $stockDbData = $this->getStockTable()->getItem($productIncomingData->getProductUid());
                $diffStock = array_diff($stockIncomingData->toArray(),$stockDbData->toArray());
                if( ! empty($diffStock) ) {
                    $stockRowsAffected = $this->getStockTable()->updateItem($stockDbData->getProductUid(),$diffStock);
                }
            }
        } else {
            echo 'product not found. Save new Item';
        }

        return ['rows_affected'=>['product'=>$productRowsAffected,'stock'=>$stockRowsAffected]];

    }


}
