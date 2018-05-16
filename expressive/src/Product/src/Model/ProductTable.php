<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Product\Model;

use Zend\Db\TableGateway\TableGateway;

class ProductTable
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

    public function getItemCount($product_uid = null)
    {
        if ($product_uid===null) {
            return 0;
        }
        if (is_array($product_uid)) {
            $rowset = $this->tableGateway->select($product_uid);
        } else {
            $rowset = $this->tableGateway->select(['product_uid' => $product_uid]);
        }
        $row = $rowset->current();
        if (!$row) {
            return 0;
        }

        return $row;
    }
}
