<?php
namespace Stock\Service;

use Stock\Model\StockTable;
use Stock\Model\StockBarcodeTable;

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
    /**
     *
     *
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function getItems()
    {
        $cartProducts = $this->stockTable->fetchAll();

        if (!empty($cartProducts)) {
            return $cartProducts;
        }

        return null;
    }

    /**
     * Returns cartProduct by cartId and productId
     *
     * @param $id
     * @return \Product\Model\ProductModel
     */
    public function getItem($productId)
    {
        return $this->productTable->getItem($productId);
    }

}
