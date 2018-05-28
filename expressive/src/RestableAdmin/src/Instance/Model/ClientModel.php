<?php

declare(strict_types=1);

namespace RestableAdmin\Instance\Model;


class ClientModel
{
    public $application_uid;
    public $client_uid;
    public $status;
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
        $this->client_uid = (!empty($data['client_uid'])) ? $data['client_uid'] : null;
        $this->status = (!empty($data['status'])) ? $data['status'] : null;
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
        if ($this->client_uid !== null) {
            $data['client_uid'] = $this->client_uid;
        }
        if ($this->status !== null) {
            $data['status'] = $this->status;
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
     * @return VenueModel
     */
    public function setApplicationUid($application_uid)
    {
        $this->application_uid = $application_uid;
        return $this;
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
     * @return VenueModel
     */
    public function setClientUid($client_uid)
    {
        $this->client_uid = $client_uid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return VenueModel
     */
    public function setStatus($status)
    {
        $this->status = $status;
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
     * @return VenueModel
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
     * @return VenueModel
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

}
