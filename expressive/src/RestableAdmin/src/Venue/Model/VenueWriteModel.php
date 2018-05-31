<?php

declare(strict_types=1);

namespace RestableAdmin\Venue\Model;

class VenueWriteModel
{
    public $fieldset_venue;
    public $collection_contact;
    public $collection_address;
    public $fieldset_status;

    public function __construct(array $data = [])
    {
        if (! empty($data)) {
            $this->exchangeArray($data);
        }
    }


    public function exchangeArray(array $data = [])
    {
        $this->fieldset_venue = (!empty($data['fieldset_venue'])) ? $data['fieldset_venue'] : null;
        $this->fieldset_status = (!empty($data['fieldset_status'])) ? $data['fieldset_status'] : null;
        $this->collection_contact = (!empty($data['collection_contact'])) ? $data['collection_contact'] : null;
        $this->collection_address = (!empty($data['collection_address'])) ? $data['collection_address'] : null;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data=[];

        if ($this->fieldset_venue !== null) {
            $data['fieldset_venue'] = $this->fieldset_venue;
        }
        if ($this->collection_contact !== null) {
            $data['collection_contact'] = $this->collection_contact;
        }
        if ($this->collection_address !== null) {
            $data['collection_address'] = $this->collection_address;
        }
        if ($this->fieldset_status !== null) {
            $data['fieldset_status'] = $this->fieldset_status;
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

    public function get(string $index = null)
    {
        if( ! is_null($index) && property_exists($this,$index)) {
            return $this->{$index};
        }

        return null;
    }

    /**
     * @return mixed
     */
    public function getFieldsetVenue()
    {
        return $this->fieldset_venue;
    }

    /**
     * @param mixed $fieldset_venue
     * @return VenueWriteModel
     */
    public function setFieldsetVenue($fieldset_venue)
    {
        $this->fieldset_venue = $fieldset_venue;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCollectionContact()
    {
        return $this->collection_contact;
    }

    /**
     * @param mixed $collection_contact
     * @return WriteModel
     */
    public function setCollectionContact($collection_contact)
    {
        $this->collection_contact = $collection_contact;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCollectionAddress()
    {
        return $this->collection_address;
    }

    /**
     * @param mixed $collection_address
     * @return WriteModel
     */
    public function setCollectionAddress($collection_address)
    {
        $this->collection_address = $collection_address;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFieldsetStatus()
    {
        return $this->fieldset_status;
    }

    /**
     * @param mixed $fieldset_status
     * @return WriteModel
     */
    public function setFieldsetStatus($fieldset_status)
    {
        $this->fieldset_status = $fieldset_status;
        return $this;
    }

}
