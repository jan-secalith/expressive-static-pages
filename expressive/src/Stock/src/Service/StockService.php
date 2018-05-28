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
use Stock\Model\StockRemoveModel;
use Stock\Model\StockStatusModel;
use Stock\Model\StockStatusTable;
use Stock\Model\StockTable;
use Stock\Model\StockWriteModel;
use Zend\Cache\Storage\Adapter\AbstractAdapter;

class StockService implements CacheServiceAwareInterface
{

    use CacheServiceAwareTrait;

    protected $serviceConfig;
    /**
     * @var StockTable
     */
    protected $stockTable;

    /**
     * @var ProductTable
     */
    protected $productTable;

    /**
     * @var StockStatusTable
     */
    protected $stockStatusTable;

    /**
     * @var StockBarcodeTable
     */
    protected $stockBarcodeTable;

    public function __construct(
        StockTable $stockTable = null,
        ProductTable $productTable = null,
        StockStatusTable $stockStatusTable = null,
        StockBarcodeTable $stockBarcodeTable = null,
        AbstractAdapter $cacheService = null,
        array $configStockService = []
    )
    {
        $this->stockTable = $stockTable;
        $this->productTable = $productTable;
        $this->stockStatusTable = $stockStatusTable;
        $this->stockBarcodeTable = $stockBarcodeTable;
        $this->setCacheService($cacheService);
        $this->serviceConfig = $configStockService;
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
    public function  getStockBarcodeTable()
    {
        return $this->stockBarcodeTable;
    }

    /**
     * @return StockStatusTable
     */
    public function  getStockStatusTable()
    {
        return $this->stockStatusTable;
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

    /**
     * @param $productUid
     * @return \Stock\Model\StockProductModel|null
     * @throws \Exception
     */
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
        $barcodesIncomingData = $stockProductItem->getFieldsetBarcode();
        $statusIncomingData = $stockProductItem->getFieldsetStatus();
        $productRowsAffected = 0;
        $stockRowsAffected = 0;
        $barcodeRowsAffected = 0;
        $statusRowsAffected = 0;

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
            $stockDbData = $this->getStockTable()->getItem($productIncomingData->getProductUid());
            if($this->stockTable->getItemCount($stockIncomingData->getProductUid())>0) {
                // Stock for the product exists
                $diffStock = array_diff($stockIncomingData->toArray(),$stockDbData->toArray());
                if( ! empty($diffStock) ) {
                    $stockRowsAffected = $this->getStockTable()->updateItem($stockDbData->getProductUid(),$diffStock);
                }
            } else {
                // stock for the Product never been created
                $stockIncomingData->setProductUid($productIncomingData->getProductUid());
                $stockIncomingData->setStockUid($productIncomingData->getProductUid());


                $stockRowsAffected = $this->getStockTable()->saveItem($stockIncomingData);
            }
            $stockDbData = $this->getStockTable()->getItem($productIncomingData->getProductUid());
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
            //Determine if status has been changed
            $statusDbData = $this->getStockStatusTable()->getItemByProductUid($productIncomingData->getProductUid());


            if($statusDbData===null) {
                $statusDefault = StockStatusModel::STOCK_STATUS_PATHS[StockStatusModel::STOCK_STATUS_DEFAULT];
                // the status entry never been created
                $diffModel = new StockStatusModel(
                    [
                        'product_uid'=>$productDbData->getProductUid(),
                        'stock_uid'=>$stockDbData->getStockUid(),
                        'status_code'=>$statusDefault,
                    ]
                );
                // get available statuses
                $av=$diffModel->getStatusAvailableWithLabels();

                if(in_array($diffModel->getStatusCode(),$av)) {
                    // status is opn available path
                    $statusRowsAffected += $this->getStockStatusTable()->saveItem($diffModel);

                }
//                $statusRowsAffected += $this->getStockStatusTable()->saveItem($diffModel);

            } elseif($statusDbData instanceof StockStatusModel) {
                $diffStatus = array_diff($statusIncomingData->toArray(),$statusDbData->toArray());

                if(empty($diffStatus)) {

                } else {
                    // status has changed. check with statusResolver if allowed


                    $diffModel = new StockStatusModel($diffStatus);
                    $diffModel->setStockUid($statusDbData->getStockUid())
                        ->setProductUid($statusDbData->getProductUid());

                    // get available statuses
                    $av=$diffModel->getStatusAvailableWithLabels();

                    if(in_array($diffModel->getStatusCode(),$av)||array_key_exists($diffModel->getStatusCode(),$av)) {
                        // status is opn available path
                        $statusRowsAffected += $this->getStockStatusTable()->updateStatus($diffModel);

                    }
                }
            }

        } else {
            // This is a new product
            $pUid = $this->generateUUID();
            $productIncomingData->setProductUid($pUid);
            $stockIncomingData->setProductUid($pUid);
            $stockIncomingData->setStockUid($this->generateUUID());
            $stockIncomingData->setStockStatus(StockStatusModel::STOCK_STATUS_NEW);
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
                'status'=>$statusRowsAffected,
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

    /**
     * In case if stock_status is not deined the method returns the `default` StockStatusModel,
     * with data based on the $productUid
     *
     * @param $productUid
     * @return CommonCollection|null
     * @throws \Exception
     */
    public function getStatusByProductUid($productUid)
    {
        $stockProduct = $this->getItem($productUid);
        $statusCurrent = $this->stockStatusTable->getItemByProductUid($productUid);
        $collection = new CommonCollection();

        if($statusCurrent!==null)
        {
            $collection->addItem($statusCurrent);

            return $collection;
        }

        // return default status
        $defaults = [
            'product_uid' => $stockProduct->getProductUid(),
            'stock_uid' => $stockProduct->getStockUid(),
            'status_code' => (int)StockStatusModel::STOCK_STATUS_PATHS[StockStatusModel::STOCK_STATUS_DEFAULT],
        ];

        $defaultsModel = new StockStatusModel($defaults);

        $collection->addItem($defaultsModel);

        return $collection;
    }

    public function changeStockProductStatus(StockRemoveModel $stockProductItem = null)
    {
        if( ! empty($this->serviceConfig) && array_key_exists('remove_purge',$this->serviceConfig)) {

            $purge = $this->serviceConfig['remove_purge'];
            if( $purge === true) {
                // DELETE

                // count barcodes
                $cBarcodes = $this->getBarcodeItemByProductUid($stockProductItem->getProductUid())->count();
                if( $cBarcodes > 0 ) {
                    // start DB transaction
                    #TODO move to the table
                    $barcodesConnection = $this->getStockTable()->getTableGateway()->getAdapter()->getDriver()->getConnection();
                    $barcodesConnection->beginTransaction();

                    $barcodesRemovedCount = $this->getStockBarcodeTable()->deleteAllByProduct($stockProductItem);

                } else {
                    $barcodesConnection = null;
                }

                // stock
                $stockConnection = $this->getStockTable()->getTableGateway()->getAdapter()->getDriver()->getConnection();
                $stockConnection->beginTransaction();

                $stockRemovedCount = $this->getStockTable()->deleteItem($stockProductItem);

                // product
                $productConnection = $this->getStockTable()->getTableGateway()->getAdapter()->getDriver()->getConnection();
                $productConnection->beginTransaction();

                $productRemovedCount = $this->getProductTable()->deleteItem($stockProductItem);

                // start with barcodes as last dependency
                if($cBarcodes > 0 && $barcodesRemovedCount > 0 && $cBarcodes === $barcodesRemovedCount) {
                    $barcodesConnection->commit();
                    $stockConnection->commit();
                    $productConnection->commit();
                } elseif($cBarcodes==0 && $stockRemovedCount>0 && $productRemovedCount>0) {
                    // remove stock and product
                    $stockConnection->commit();
                    $productConnection->commit();
                } else {
                    // something went wrong
                    #TODO
                    if($cBarcodes==0) {
                        $barcodesConnection->rollback();
                    }
                    $stockConnection->rollback();
                    $productConnection->rollback();
                }
            } else {
                // Set Status to removed

                // get current status
                echo $currentStockStatus = $this->getStatusByProductUid($stockProductItem->getProductUid());
                $stockStatusPaths = StockModel::STOCK_STATUS_PATHS;

                var_dump($currentStockStatus);

            }
        }
    }

}
