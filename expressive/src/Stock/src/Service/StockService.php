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

    /**
     *
     *
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function getItems()
    {
        $cartProducts = $this->productTable->fetchAll();

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
