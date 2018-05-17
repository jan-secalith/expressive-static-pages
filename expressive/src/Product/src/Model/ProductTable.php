<?php

declare(strict_types=1);

namespace Product\Model;

use Product\Model\ProductModel;
use Common\Model\WriteTableInterface;
use Zend\Db\TableGateway\TableGateway;

class ProductTable implements WriteTableInterface
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

    public function getTableGateway()
    {
        return $this->tableGateway;
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

    /**
     * @param integer $id
     * @return array|\ArrayObject|null
     * @throws \Exception
     */
    public function getItem($id)
    {
        $rowset = $this->tableGateway->select(['product_uid' => $id]);
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    /**
     * @param string $value
     * @param string $name
     * @return array|\ArrayObject|null
     * @throws \Exception
     */
    public function fetchBy($value, $name = "id")
    {
        $rowset = $this->tableGateway->select([$name => $value]);
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $value");
        }
        return $row;
    }

    public function getItemCount($product_uid = null) : int
    {
        if ($product_uid===null) {
            return 0;
        }
        if (is_array($product_uid)) {
            $rowset = $this->tableGateway->select($product_uid);
        } else {
            $rowset = $this->tableGateway->select(['product_uid' => $product_uid]);
        }

        return $rowset->count();
    }

    public function updateItem($uid,$data)
    {
        $rowsAffected = $this->tableGateway->update($data, ['product_uid' => $uid]);

        return $rowsAffected;
    }

    public function saveItem($item)
    {
        $dateTime = new \DateTime('now');

        $data = [
            'product_uid' => $item->getProductUid(),
            'name' => $item->getName(),
            'price' => $item->getPrice(),
            'unit' => $item->getUnit(),
            'description_short' => $item->getDescriptionShort(),
            'created' => $dateTime->format('Y-m-d\TH:i:s.u'),
        ];

        $this->tableGateway->insert($data);
    }
}
