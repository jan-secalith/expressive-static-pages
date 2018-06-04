<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace RestableAdmin\Contact\Model;

use RestableAdmin\Contact\Model\ContactModel;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid;
use Zend\Db\TableGateway\TableGateway;

class ContactTable
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

    public function getItemByClientUid($client_uid)
    {
        $rowset = $this->tableGateway->select(['client_uid' => $client_uid]);

        $row = $rowset->buffer();

        return $row;
    }

    /**
     * @param \RestableAdmin\Client\Model\Model $item
     */
    public function saveItem(ContactModel $item)
    {
        $timeNow = new \DateTime('now');

        if(empty($item->getContactUid())) {
            $item->setContactUid($this->generateUUID());
        }
        if(empty($item->getStatus())) {
            $item->setStatus(ContactModel::STATUS_NEW);
        }

        $data = [
            'client_uid' => $item->getClientUid(),
            'contact_uid' => $item->getContactUid(),
            'contact_name' => $item->getContactName(),
            'contact_email' => $item->getContactEmail(),
            'contact_phone' => $item->getContactPhone(),
            'contact_notes' => $item->getContactNotes(),
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

    /**
     * @return string
     */
    private function generateUUID()
    {
        #TODO: make as Adapter
        try {
            $uuid4 = Uuid::uuid4();

            return $uuid4->toString();
        } catch (UnsatisfiedDependencyException $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
    }

}
