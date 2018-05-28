<?php

declare(strict_types=1);

namespace Order\Model;

use Zend\Db\TableGateway\TableGateway;

class OrderItemTable
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

        return $resultSet;
    }

    public function fetchAllBy($data)
    {
        $resultSet = $this->tableGateway->select(function ($select) use ($data) {

            foreach ($data as $name => $value) {
                $select->where->in($name, [$value]);
            }
        });

        $resultSet->buffer();
//        $resultSet->next();

        return $resultSet;
    }

    /**
     * @param integer $id
     * @return array|\ArrayObject|null
     * @throws \Exception
     */
    public function getItem($itemId,$orderId=null)
    {
        if(is_array($itemId)&&null===$orderId) {
//            $rowset = $this->tableGateway->select($itemId);
            $rowset = $this->tableGateway->select(function ($select) use ($itemId) {
                foreach ($itemId as $name => $value) {
                    $select->where->in($name, [$value]);
                }
            });
        } else {
            $rowset = $this->tableGateway->select(['order_id' => $orderId,'product_id'=>$itemId]);
        }
        $row = $rowset->buffer();
        if (!$row) {
            throw new \Exception("Could not find row $itemId / $orderId");
        }

        return $row->current();
    }

    public function getItemCount($orderId)
    {
        $rowset = $this->tableGateway->select(['order_id' => $orderId]);
        $row = $rowset->current();
        if (!$row) {
            return 0;
        }

        return $row;
    }

    /**
     * @param string $value
     * @param string $name
     * @throws \Exception
     */
    public function fetchBy($value, $name = "id")
    {
        if( is_array($value)) {
            $rowset = $this->tableGateway->select($value);
        } else {
            $rowset = $this->tableGateway->select([$name => $value]);
        }

        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $value");
        }
        return $row;
    }

    /**
     * @param \Order\Model\OrderItemModel $item
     */
    public function saveItem($item)
    {
        $updated = new \DateTime('now');

        $data = [
            'order_id' => $item->getOrderId(),
            'product_id' => $item->getProductId(),
            'product_qty' => $item->getProductQty(),
            'price_unit' => $item->getPriceUnit(),
            'updated' => $updated->format('Y-m-d\TH:i:s.u'),
        ];
        $this->tableGateway->insert($data);
    }

    /**
     * @param \Order\Model\OrderItemModel $item
     */
    public function updateItem($item)
    {
        $data = [
            'product_qty' => $item->getProductQty(),
        ];

        $orderId = $item->getOrderId();
        $cartProductId = $item->getProductId();

        if (null===$orderId || 0===$orderId) {
            throw new \Exception('Item\'s `cartId` cannot be null');
        } else {
            if ($this->getItem(['cart_id' => $orderId,'product_id'=>$cartProductId])) {
                return $this->tableGateway->update($data, ['order_id' => $orderId,'product_id'=>$cartProductId]);
            } else {
                throw new \Exception('Item\'s `cartItemId` does not exist in db');
            }
        }
    }

    /**
     * @param \Order\Model\OrderItemModel $item
     */
    public function deleteItem($item)
    {
        $data = ['order_id' => $item->getOrderId(),'product_id'=>$item->getProductId()];
        $this->tableGateway->delete($data);
    }
}
