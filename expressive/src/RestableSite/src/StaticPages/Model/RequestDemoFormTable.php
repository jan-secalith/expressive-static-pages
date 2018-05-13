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

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        $resultSet->buffer();

        return $resultSet;
    }

    /**
     * @param \RestableSite\StaticPages\Model\RequestDemoModel $item
     */
    public function saveItem(RequestDemoModel $item)
    {
        $dateTime = new \DateTime('now');

        $data = [
            'id' => $item->getId(),
            'application_id' => $item->getApplicationId(),
            'name_first' => $item->getNameFirst(),
            'name_last' => $item->getNameLast(),
            'contact_phone' => $item->getContactPhone(),
            'contact_email' => $item->getContactEmail(),
            'venue_name' => $item->getVenueName(),
            'work_title' => $item->getWorkTitle(),
            'country' => $item->getCountry(),
            'ip' => $item->getIp(),
            'created' => $dateTime->format('Y-m-d\TH:i:s.u'),
        ];
        $this->tableGateway->insert($data);
    }
}
