<?php

declare(strict_types=1);

namespace RestableSite\StaticPages\Model;

use RestableSite\StaticPages\Model\RequestDemoModel;
use Zend\Db\TableGateway\TableGateway;

class RequestDemoFormTable
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

    public function fetchByIpAndDateCount($ip=null,$date=null)
    {
        $resultSet = $this->tableGateway->select(['ip = ?'=>$ip,'created >= ?'=>$date]);
        $resultSet->buffer();

        return $resultSet->count();
    }

    /**
     * @param \RestableSite\StaticPages\Model\RequestDemoModel $item
     */
    public function saveItem(RequestDemoModel $item)
    {
        $dateTime = new \DateTime('now');

        $data = [
            'application_id' => $item->getApplicationId(),
            'contact_email' => $item->getContactEmail(),
            'contact_phone' => $item->getContactPhone(),
            'created' => $dateTime->format('Y-m-d\TH:i:s.u'),
            'id' => $item->getId(),
            'ip' => $item->getIp(),
            'name_first' => $item->getNameFirst(),
            'name_last' => $item->getNameLast(),
            'status' => RequestDemoModel::STATUS_NEW,
            'venue_name' => $item->getVenueName(),
            'work_title' => $item->getWorkTitle(),
        ];
        $this->tableGateway->insert($data);
    }
}
