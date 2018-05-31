<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace RestableAdmin\Client\Model;

use RestableAdmin\Client\Model\Model;
use Zend\Db\TableGateway\TableGateway;
use Common\Model\GerenateUUIDTrait;

class Table
{
    use GerenateUUIDTrait;

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

    /**
     * @param integer $id
     * @return array|\ArrayObject|null
     * @throws \Exception
     */
    public function getItem($id)
    {
        $rowset = $this->tableGateway->select(['order_id' => $id]);
        $row = $rowset->current();
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
            $rowset = $this->tableGateway->select(['order_id' => $id]);
        }
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
    public function fetchBy($value, $name = "order_id")
    {
        $rowset = $this->tableGateway->select([$name => $value]);
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $value");
        }
        return $row;
    }

    /**
     * @param \RestableAdmin\Client\Model\Model $item
     */
    public function saveItem(Model $item)
    {
        $timeNow = new \DateTime('now');

        if(empty($item->getClientUid())) {
            $item->setClientUid($this->generateUUID());
        }
        if(empty($item->getStatus())) {
            $item->setStatus(Model::STATUS_NEW);
        }

        $data = [
            'client_uid' => $item->getClientUid(),
            'client_name' => $item->getClientName(),
            'status' => $item->getStatus(),
            'created' => $timeNow->format('Y-m-d\TH:i:s.u'),
        ];

        $rowsAffected = $this->tableGateway->insert($data);

        return ['rows_affected'=>$rowsAffected,'item'=>$item];
    }

    public function deleteItem($item)
    {
        $data = ['order_id' => $item->getOrderId()];
        $this->tableGateway->delete($data);
    }
}
