<?php

declare(strict_types=1);

namespace RestableAdmin\Instance\Model;

use Common\Model\CommonModelInterface;

class ApplicationModel implements CommonModelInterface
{
    public $application_uid;
    public $application_client_uid;
    public $application_status;
    public $updated;
    public $created;

    public const APPLICATION_STATUS_NEW = 0;
    public const APPLICATION_STATUS_PROCESSING = 1;
    public const APPLICATION_STATUS_DEPLOYED = 2;
    public const APPLICATION_STATUS_ACTIVE = 3;
    public const APPLICATION_STATUS_SUSPENDED = 4;
    public const APPLICATION_STATUS_REMOVED = 5;
    public const APPLICATION_STATUS_ARCHIVED = 6;

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
     * @return OrderModel
     */
    public function exchangeArray(array $data = [])
    {
        $this->application_uid = (!empty($data['application_uid'])) ? $data['application_uid'] : null;
        $this->application_client_uid = (!empty($data['application_client_uid'])) ? $data['application_client_uid'] : null;
        $this->application_status = (!empty($data['application_status'])) ? $data['application_status'] : null;
        $this->updated = (!empty($data['updated'])) ? $data['updated'] : null;
        $this->created = (!empty($data['created'])) ? $data['created'] : null;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [];
        if ($this->application_uid !== null) {
            $data['application_uid'] = $this->application_uid;
        }
        if ($this->application_client_uid !== null) {
            $data['application_client_uid'] = $this->application_client_uid;
        }
        if ($this->application_status !== null) {
            $data['application_status'] = $this->application_status;
        }
        if ($this->created !== null) {
            $data['created'] = $this->created;
        }
        if ($this->updated !== null) {
            $data['updated'] = $this->updated;
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
    public function getApplicationUid()
    {
        return $this->application_uid;
    }

    /**
     * @param mixed $application_uid
     * @return ClientModel
     */
    public function setApplicationUid($application_uid)
    {
        $this->application_uid = $application_uid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getApplicationClientUid()
    {
        return $this->application_client_uid;
    }

    /**
     * @param mixed $application_client_uid
     * @return ClientModel
     */
    public function setApplicationClientUid($application_client_uid)
    {
        $this->application_client_uid = $application_client_uid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getApplicationStatus()
    {
        return $this->application_status;
    }

    /**
     * @param mixed $application_status
     * @return ClientModel
     */
    public function setApplicationStatus($application_status)
    {
        $this->application_status = $application_status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param mixed $updated
     * @return ClientModel
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     * @return ClientModel
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

}
