<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace RestableAdmin\Category\Model;

use RestableAdmin\Category\Model\CategoryModel;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid;
use Zend\Db\TableGateway\TableGateway;

class CategoryTable
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

    /**
     * @param \RestableAdmin\Category\Model\CategoryModel $item
     */
    public function saveItem(CategoryModel $item)
    {
        $timeNow = new \DateTime('now');

        if(empty($item->getCategoryUid())) {
            $item->setCategoryUid($this->generateUUID());
        }
        if(empty($item->getStatus())) {
            $item->setStatus(CategoryModel::STATUS_NEW);
        }

        $data = [
            'category_uid' => $item->getCategoryUid(),
            'category_parent' => $item->getCategoryParent(),
            'label' => $item->getLabel(),
            'status' => $item->getStatus(),
            'created' => $timeNow->format('Y-m-d\TH:i:s.u'),
        ];
        $result =  $this->tableGateway->insert($data);

        return $result;
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
