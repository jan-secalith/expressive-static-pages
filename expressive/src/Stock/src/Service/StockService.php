<?php

declare(strict_types=1);

namespace Stock\Service;

use Common\Model\CommonCollection;
use Common\Service\CacheServiceAwareInterface;
use Common\Service\CacheServiceAwareTrait;
use Product\Model\ProductTable;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid;
use Stock\Model\StockBarcodeTable;
use Stock\Model\StockModel;
use Stock\Model\StockTable;
use Stock\Model\StockWriteModel;
use Zend\Cache\Storage\Adapter\AbstractAdapter;

class StockService implements CacheServiceAwareInterface
{

    use CacheServiceAwareTrait;

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
        StockBarcodeTable $stockBarcodeTable = null,
        AbstractAdapter $cacheService = null
    )
    {
        $this->stockTable = $stockTable;
        $this->productTable = $productTable;
        $this->stockBarcodeTable = $stockBarcodeTable;
        $this->setCacheService($cacheService);
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

    /**
     * @return StockBarcodeTable
     */
    public function getStockBarcodeTable()
    {
        return $this->stockBarcodeTable;
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

    public function getItem($productUid)
    {
        return $this->stockTable->getItem($productUid);
    }

    public function getBarcodeItem($barcodeValue)
    {
        return $this->stockBarcodeTable->getItem($barcodeValue);
    }
    public function getBarcodeItemByProductUid($productUid)
    {
        $barcodes = $this->stockBarcodeTable->getItemByProductUid($productUid);
        $collection = new CommonCollection();

        if($barcodes!==null && $barcodes->count()>0) {
            foreach($barcodes as $barcode) {
                $collection->addItem($barcode);
            }

            return $collection;
        }

        return $collection;
    }

    public function getByBarcode($barcode)
    {
        return $this->stockBarcodeTable->getItem($barcode);
    }

    public function addStockProduct(StockWriteModel $stockProductItem = null)
    {
        $productIncomingData = $stockProductItem->getFieldsetProduct();
        $stockIncomingData = $stockProductItem->getFieldsetStock();
        $barcodesIncomingData = $stockProductItem->getfieldsetBarcode();
        $productRowsAffected = 0;
        $stockRowsAffected = 0;
        $barcodeRowsAffected = 0;

        // determine if product already exists
        if($this->getProductTable()->getItemCount($productIncomingData->getProductUid())>0) {
            // Product exists
            // Determine if Product data has changed
            $productDbData = $this->getProductTable()->getItem($productIncomingData->getProductUid());
            $diffProduct = array_diff($productIncomingData->toArray(),$productDbData->toArray());
            if( ! empty($diffProduct) ) {
                $productRowsAffected = $this->getProductTable()->updateItem($productDbData->getProductUid(),$diffProduct);
            }
            // Determine if Stock has been changed
            if($this->stockTable->getItemCount($stockIncomingData->getProductUid())>0) {
                // Stock for the product exists
                $stockDbData = $this->getStockTable()->getItem($productIncomingData->getProductUid());
                $diffStock = array_diff($stockIncomingData->toArray(),$stockDbData->toArray());
                if( ! empty($diffStock) ) {
                    $stockRowsAffected = $this->getStockTable()->updateItem($stockDbData->getProductUid(),$diffStock);
                }
                // Determine if Barcode has been changed
                $barcodeDbData = $this->getStockBarcodeTable()->getItemByProductUid($productIncomingData->getProductUid());
                if($barcodeDbData->count()>0) {
                    // barcode for the product exists
                    #TODO
                } else {
                    // the stock product has no barcodes attached
                    foreach($barcodesIncomingData as $barcodeItem) {
                        if( ! empty($barcodeItem->getBarcodeValue())) {
                            $barcodeItem->setProductUid($productDbData->getProductUid());
                            $this->getStockBarcodeTable()->saveItem($barcodeItem);
                            $barcodeRowsAffected ++;
                        }
                    }
                }

            } else {
                // stock for the Product never been created
                $stockIncomingData->setProductUid($productIncomingData->getProductUid());
                $stockIncomingData->setStockUid($productIncomingData->getProductUid());

                $stockRowsAffected = $this->getStockTable()->saveItem($stockIncomingData);
            }
        } else {
            // This is a new product
            $pUid = $this->generateUUID();
            $productIncomingData->setProductUid($pUid);
            $stockIncomingData->setProductUid($pUid);
            $stockIncomingData->setStockUid($this->generateUUID());
            $stockIncomingData->setStockStatus(StockModel::STOCK_STATUS_NEW);
//            $barcodesIncomingData->setProductUid($pUid);

            #TODO: DB rollback

            $productRowsAffected = $this->getProductTable()->saveItem($productIncomingData);
            $stockRowsAffected = $this->getStockTable()->saveItem($stockIncomingData);
            // BARCODES:
            if( ! empty($barcodesIncomingData)) {
                foreach($barcodesIncomingData as $barcodeItem) {
                    #todo isValid?
                    $barcodeItem->setProductUid($pUid);
                    $barcodeRowsAffected += $this->getStockBarcodeTable()->saveItem($barcodeItem);
                }
            }
        }

        return [
            'rows_affected'=>[
                'product'=>$productRowsAffected,
                'stock'=>$stockRowsAffected,
                'barcode'=>$barcodeRowsAffected,
            ],
        ];

    }

    /**
     * @return string
     */
    private function generateUUID()
    {
        try {
            $uuid4 = Uuid::uuid4();

            return $uuid4->toString();
        } catch (UnsatisfiedDependencyException $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
    }

}
