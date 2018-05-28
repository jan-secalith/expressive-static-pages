<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Stock\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;

class StockBarcodeTable
{
    /**
     * @var TableGateway
     */
    protected $tableGateway;

    /**
     * ProductTable constructor.
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        $resultSet->buffer();
        $resultSet->next();

        return $resultSet;
    }

    public function getItem($stock_barcode)
    {
        if( ! is_array($stock_barcode)) {
            $rowset = $this->tableGateway->select(['barcode_value' => $stock_barcode]);
        } else {
            $rowset = $this->tableGateway->select($stock_barcode);
        }

        $row = $rowset->current();

        if (!$row) {
            return null;
        }

        return $row;
    }



    public function getItemByProductUid($product_uid)
    {
        $rowset = $this->tableGateway->select(['product_uid' => $product_uid]);

        $row = $rowset->buffer();

        if (!$row) {
            return null;
        }

        return $row;
    }

    public function getItemCount($id = null)
    {
        if ($id===null) {
            return 0;
        }
        if (is_array($id)) {
            $rowset = $this->tableGateway->select($id);
        } else {
            $rowset = $this->tableGateway->select(['product_id' => $id]);
        }
        $row = $rowset->current();
        if (!$row) {
            return 0;
        }

        return $row;
    }

    public function fetchBy($value, $name = "product_uid")
    {
        $rowset = $this->tableGateway->select([$name => $value]);
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $value");
        }
        return $row;
    }

    public function saveItem($item)
    {
        $dateTime = new \DateTime('now');

        $data = [
            'product_uid' => $item->getProductUid(),
            'barcode_value' => strtoupper($item->getBarcodeValue()),
            'created' => $dateTime->format('Y-m-d\TH:i:s.u'),
        ];

        $this->tableGateway->insert($data);
    }

    public function deleteItem($item)
    {
        $data = ['product_id' => $item->getProductId(),'code' => $item->getProductId()];
        $this->tableGateway->delete($data);
    }

    public function deleteAllByProduct($item)
    {
        $data = ['product_uid' => $item->getProductUid()];
        return $this->tableGateway->delete($data);
    }

    public function updateStatus($item)
    {

        $data = [
            'status' => $item->getStatus(),
        ];

        $cartId = $item->getCartId();
//        $cartProductId = $item->getProductId();

        if (null===$cartId || 0===$cartId) {
            throw new \Exception('Item\'s `cartId` cannot be null');
        } else {
            if ($this->getItem($cartId)) {
                $this->tableGateway->update($data, ['cart_id' => $cartId]);
            } else {
                throw new \Exception('Item\'s `cartId` does not exist');
            }
        }
    }

}
