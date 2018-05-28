<?php

declare(strict_types=1);

namespace RestableAdmin\Contact\Model;

class ContactWriteModel
{
    public $fieldset_client;
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
        $this->fieldset_client = (!empty($data['fieldset_client'])) ? $data['fieldset_client'] : null;
        $this->collection_contact = (!empty($data['collection_contact'])) ? $data['collection_contact'] : null;
        $this->collection_address = (!empty($data['collection_address'])) ? $data['collection_address'] : null;
        $this->fieldset_status = (!empty($data['fieldset_status'])) ? $data['fieldset_status'] : null;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data=[];

        if ($this->fieldset_client !== null) {
            $data['fieldset_client'] = $this->fieldset_client;
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

    public function getFieldsetClient()
    {
        return $this->fieldset_client;
    }

    public function setFieldsetClient( $fieldset_client): ClientWriteModel
    {
        $this->fieldset_client = $fieldset_client;
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
     * @return ClientWriteModel
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
     * @return ClientWriteModel
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
     * @return ClientWriteModel
     */
    public function setFieldsetStatus($fieldset_status)
    {
        $this->fieldset_status = $fieldset_status;
        return $this;
    }

}
