<?php

declare(strict_types=1);

namespace RestableAdmin\Venue\Model;

use Common\Model\CommonModelInterface;

class VenueModel implements CommonModelInterface
{
    public $client_uid;
    public $venue_uid;
    public $status;
    public $updated;
    public $created;

    public const VENUE_STATUS_NEW = 0;
    public const VENUE_STATUS_PROCESSING = 1;
    public const VENUE_STATUS_DEPLOYED = 2;
    public const VENUE_STATUS_ACTIVE = 3;
    public const VENUE_STATUS_SUSPENDED = 4;
    public const VENUE_STATUS_REMOVED = 5;
    public const VENUE_STATUS_ARCHIVED = 6;

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
        $this->venue_uid = (!empty($data['venue_uid'])) ? $data['venue_uid'] : null;
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
        if ($this->venue_uid !== null) {
            $data['venue_uid'] = $this->venue_uid;
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
    public function getVenueUid()
    {
        return $this->venue_uid;
    }

    /**
     * @param mixed $venue_uid
     * @return VenueModel
     */
    public function setVenueUid($venue_uid)
    {
        $this->venue_uid = $venue_uid;
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
