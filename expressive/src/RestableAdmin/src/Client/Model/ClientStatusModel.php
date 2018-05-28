<?php

declare(strict_types=1);

namespace RestableAdmin\Client\Model;

use Common\Model\CommonModelInterface;

/**
 * Uses Contstants as those data never changes;
 *
 * Class StockStatusModel
 * @package Stock\Model
 */
class ClientStatusModel implements CommonModelInterface
{

    public $client_uid;
    public $status_code;

    const STOCK_STATUS_DEFAULT = 'default';
    const STOCK_STATUS_NEW = 0;
    const STOCK_STATUS_REMOVED = 1;
    const STOCK_STATUS_DISABLED = 2;
    const STOCK_STATUS_ENABLED = 3;
    const STOCK_STATUS_ARCHIVED = 4;

    const STOCK_STATUS_NEW_NOT_SPECIFIED_LABEL = "Unspecified";
    const STOCK_STATUS_NEW_LABEL = "New";
    const STOCK_STATUS_REMOVED_LABEL = "Removed";
    const STOCK_STATUS_DISABLED_LABEL = "Disabled";
    const STOCK_STATUS_ENABLED_LABEL = "Enabled";
    const STOCK_STATUS_ARCHIVED_LABEL = "Archived";

    const STOCK_STATUS_PATHS = [
        self::STOCK_STATUS_DEFAULT => self::STOCK_STATUS_NEW,
        self::STOCK_STATUS_NEW => [
            self::STOCK_STATUS_DISABLED,
            self::STOCK_STATUS_ENABLED,
        ],
        self::STOCK_STATUS_DISABLED => [
            self::STOCK_STATUS_REMOVED,
            self::STOCK_STATUS_ARCHIVED,
            self::STOCK_STATUS_ENABLED,
        ],
        self::STOCK_STATUS_ENABLED => [
            self::STOCK_STATUS_REMOVED,
            self::STOCK_STATUS_ARCHIVED,
            self::STOCK_STATUS_DISABLED,
        ],
        self::STOCK_STATUS_REMOVED => [
            self::STOCK_STATUS_DISABLED,
            self::STOCK_STATUS_ARCHIVED,
        ],
        self::STOCK_STATUS_ARCHIVED => [
            self::STOCK_STATUS_DISABLED,
            self::STOCK_STATUS_REMOVED,
        ],
    ];

    public static function getStatusAll($include_default = false)
    {
        // Inlcude default option if permitted:
        $statuses=($include_default!==false&&$include_default!==null)?['default'=>self::STOCK_STATUS_NEW_NOT_SPECIFIED_LABEL]:[];

        $statuses[self::STOCK_STATUS_NEW] = self::STOCK_STATUS_NEW_LABEL;
        $statuses[self::STOCK_STATUS_REMOVED] = self::STOCK_STATUS_REMOVED_LABEL;
        $statuses[self::STOCK_STATUS_DISABLED] = self::STOCK_STATUS_DISABLED_LABEL;
        $statuses[self::STOCK_STATUS_ENABLED] = self::STOCK_STATUS_ENABLED_LABEL;
        $statuses[self::STOCK_STATUS_ARCHIVED] = self::STOCK_STATUS_ARCHIVED_LABEL;

        return $statuses;
    }

    /**
     * Returns (bool)false if status is invalid.
     *
     * @param $status
     * @return bool
     */
    public function getStatusAvailable($status=self::STOCK_STATUS_DEFAULT)
    {
        $status = is_numeric($status)?(int)$status:$status;
        if( ! array_key_exists($status,self::STOCK_STATUS_PATHS)) {
            return false;
        } else {
            $statusAll = $this->getStatusAll(false);
            $status = ($status===self::STOCK_STATUS_DEFAULT)?self::STOCK_STATUS_PATHS[self::STOCK_STATUS_DEFAULT]:$status;
            $statusAvailable = self::STOCK_STATUS_PATHS[$status];

            return $statusAvailable;
        }
    }

    public function getStatusAvailableWithLabels($status=self::STOCK_STATUS_DEFAULT,$preserveDefault=false)
    {
        $output = [];
        if( ! $preserveDefault && ! is_numeric($status)) {

        } else {
            $status = (int) $status;
        }
        $statusAvailable = $this->getStatusAvailable($status);
        $statusAllWithLabels = self::getStatusAll();
        foreach($statusAvailable as $statusCode) {
            $output[(int)$statusCode] = $statusAllWithLabels[$statusCode];
        }

        return $output;
    }

    public static function getStatusCurrentWithLabel($status=self::STOCK_STATUS_DEFAULT)
    {
        $statusAll = self::getStatusAll(true);

        return [$status=>$statusAll[$status]];
    }

    /**
     * CartModel constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        if (! empty($data)) {
            $this->exchangeArray($data);
        }
    }

    /**
     * Populates the Object with data from the provided Array
     *
     * @param array $data
     * @return CartModel
     */
    public function exchangeArray(array $data = [])
    {
        $this->client_uid = (!empty($data['client_uid'])) ? $data['client_uid'] : null;
        $this->status_code = ( ! empty($data['status_code']) || is_numeric($data['status_code'])) ? $data['status_code'] : null;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [];
        if ($this->client_uid !== null) {
            $data['client_uid'] = $this->client_uid;
        }
        if ($this->status_code !== null) {
            $data['status_code'] = $this->status_code;
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        return $this->toArray();
    }

    /**
     * @return mixed
     */
    public function getClientUid()
    {
        return $this->client_uid;
    }

    /**
     * @param mixed $client_uid
     * @return ClientStatusModel
     */
    public function setClientUid($client_uid)
    {
        $this->client_uid = $client_uid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->status_code;
    }

    /**
     * @param mixed $status_code
     * @return StockStatusModel
     */
    public function setStatusCode($status_code)
    {
        $this->status_code = $status_code;
        return $this;
    }

}
