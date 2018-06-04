<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace RestableAdmin\Venue\Model;

use Common\Model\GerenateUUIDTrait;
use RestableAdmin\Venue\Model\VenueModel;
use Zend\Db\TableGateway\TableGateway;

class VenueTable
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

    public function getItemByClientUid($client_uid)
    {
        $rowset = $this->tableGateway->select(['client_uid' => $client_uid]);

        $row = $rowset->buffer();

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
     * @param \RestableAdmin\Venue\Model\VenueModel $item
     */
    public function saveItem(VenueModel $item)
    {
        $updated = new \DateTime('now');

        if(empty($item->getVenueUid())) {
            $item->setVenueUid($this->generateUUID());
        }
        if(empty($item->getStatus())) {
            $item->setStatus(VenueModel::STATUS_NEW);
        }

        $data = [
            'venue_uid' => $item->getVenueUid(),
            'client_uid' => $item->getClientUid(),
            'status' => $item->getStatus(),
            'created' => $updated->format('Y-m-d\TH:i:s.u'),
        ];

        $rowsAffected = $this->tableGateway->insert($data);

        return ['rows_affected'=>$rowsAffected,'item'=>$item];
    }

    /**
     * @param $item
     */
    public function deleteItem(VenueModel $item)
    {
        $data = ['venue_uid' => $item->getVenueUid()];
        $this->tableGateway->delete($data);
    }


}
