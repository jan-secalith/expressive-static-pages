<?php

declare(strict_types=1);

namespace RestableAdmin\Venue\Model;

use Common\Model\CommonModelInterface;

/**
 * Uses Contstants as those data never changes;
 *
 * Class StockStatusModel
 * @package Stock\Model
 */
class StatusModel implements CommonModelInterface
{

    public $client_uid;
    public $status_code;

    const STATUS_DEFAULT = 'default';
    const STATUS_NEW = 0;
    const STATUS_REMOVED = 1;
    const STATUS_DISABLED = 2;
    const STATUS_ENABLED = 3;
    const STATUS_ARCHIVED = 4;

    const STATUS_NEW_NOT_SPECIFIED_LABEL = "Unspecified";
    const STATUS_NEW_LABEL = "New";
    const STATUS_REMOVED_LABEL = "Removed";
    const STATUS_DISABLED_LABEL = "Disabled";
    const STATUS_ENABLED_LABEL = "Enabled";
    const STATUS_ARCHIVED_LABEL = "Archived";

    const STATUS_PATHS = [
        self::STATUS_DEFAULT => self::STATUS_NEW,
        self::STATUS_NEW => [
            self::STATUS_DISABLED,
            self::STATUS_ENABLED,
        ],
        self::STATUS_DISABLED => [
            self::STATUS_REMOVED,
            self::STATUS_ARCHIVED,
            self::STATUS_ENABLED,
        ],
        self::STATUS_ENABLED => [
            self::STATUS_REMOVED,
            self::STATUS_ARCHIVED,
            self::STATUS_DISABLED,
        ],
        self::STATUS_REMOVED => [
            self::STATUS_DISABLED,
            self::STATUS_ARCHIVED,
        ],
        self::STATUS_ARCHIVED => [
            self::STATUS_DISABLED,
            self::STATUS_REMOVED,
        ],
    ];

    public static function getStatusAll($include_default = false)
    {
        // Inlcude default option if permitted:
        $statuses=($include_default!==false&&$include_default!==null)?['default'=>self::STATUS_NEW_NOT_SPECIFIED_LABEL]:[];

        $statuses[self::STATUS_NEW] = self::STATUS_NEW_LABEL;
        $statuses[self::STATUS_REMOVED] = self::STATUS_REMOVED_LABEL;
        $statuses[self::STATUS_DISABLED] = self::STATUS_DISABLED_LABEL;
        $statuses[self::STATUS_ENABLED] = self::STATUS_ENABLED_LABEL;
        $statuses[self::STATUS_ARCHIVED] = self::STATUS_ARCHIVED_LABEL;

        return $statuses;
    }

    /**
     * Returns (bool)false if status is invalid.
     *
     * @param $status
     * @return bool
     */
    public function getStatusAvailable($status=self::STATUS_DEFAULT)
    {
        $status = is_numeric($status)?(int)$status:$status;
        if( ! array_key_exists($status,self::STATUS_PATHS)) {
            return false;
        } else {
            $statusAll = $this->getStatusAll(false);
            $status = ($status===self::STATUS_DEFAULT)?self::STATUS_PATHS[self::STATUS_DEFAULT]:$status;
            $statusAvailable = self::STATUS_PATHS[$status];

            return $statusAvailable;
        }
    }

    public function getStatusAvailableWithLabels($status=self::STATUS_DEFAULT,$preserveDefault=false)
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

    public static function getStatusCurrentWithLabel($status=self::STATUS_NEW,$preserveDefault=false)
    {
        $statusAll = self::getStatusAll( $preserveDefault);

        if($status===self::STATUS_DEFAULT && !$preserveDefault) {
            $status = self::STATUS_PATHS[$status];
        }
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
     * @return StatusModel
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
     * @return StatusModel
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
     * @return StatusModel
     */
    public function setStatusCode($status_code)
    {
        $this->status_code = $status_code;
        return $this;
    }

}
