<?php

declare(strict_types=1);

namespace RestableAdmin\Contact\Model;

class AddressModel
{
    public $address_uid;
    public $client_uid;
    public $application_uid;
    public $contact_type;
    public $address_label;
    public $first_name;
    public $last_name;
    public $address_1;
    public $address_2;
    public $postcode;
    public $city;
    public $status;
    public $address_notes;
    public $updated;
    public $created;

    public const STATUS_NEW = 0;
    public const STATUS_ACTIVE = 3;
    public const STATUS_REMOVED = 5;
    public const STATUS_ARCHIVED = 6;

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
        $this->address_uid = (!empty($data['address_uid'])) ? $data['address_uid'] : null;
        $this->client_uid = (!empty($data['client_uid'])) ? $data['client_uid'] : null;
        $this->application_uid = (!empty($data['application_uid'])) ? $data['application_uid'] : null;
        $this->contact_type = (!empty($data['contact_type'])) ? $data['contact_type'] : null;
        $this->address_label = (!empty($data['address_label'])) ? $data['address_label'] : null;
        $this->first_name = (!empty($data['first_name'])) ? $data['first_name'] : null;
        $this->last_name = (!empty($data['last_name'])) ? $data['last_name'] : null;
        $this->address_1 = (!empty($data['address_1'])) ? $data['address_1'] : null;
        $this->address_2 = (!empty($data['address_2'])) ? $data['address_2'] : null;
        $this->postcode = (!empty($data['postcode'])) ? $data['postcode'] : null;
        $this->city = (!empty($data['city'])) ? $data['city'] : null;
        $this->address_notes = (!empty($data['address_notes'])) ? $data['address_notes'] : null;
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

        if ($this->address_uid !== null) {
            $data['address_uid'] = $this->address_uid;
        }
        if ($this->client_uid !== null) {
            $data['client_uid'] = $this->client_uid;
        }
        if ($this->application_uid !== null) {
            $data['application_uid'] = $this->application_uid;
        }
        if ($this->contact_type !== null) {
            $data['contact_type'] = $this->contact_type;
        }
        if ($this->address_label !== null) {
            $data['address_label'] = $this->address_label;
        }
        if ($this->first_name !== null) {
            $data['first_name'] = $this->first_name;
        }
        if ($this->last_name !== null) {
            $data['last_name'] = $this->last_name;
        }
        if ($this->address_1 !== null) {
            $data['address_1'] = $this->address_1;
        }
        if ($this->address_2 !== null) {
            $data['address_2'] = $this->address_2;
        }
        if ($this->postcode !== null) {
            $data['postcode'] = $this->postcode;
        }
        if ($this->city !== null) {
            $data['city'] = $this->city;
        }
        if ($this->status !== null) {
            $data['status'] = $this->status;
        }
        if ($this->address_notes !== null) {
            $data['address_notes'] = $this->address_notes;
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
     * @return mixed
     */
    public function getAddressUid()
    {
        return $this->address_uid;
    }

    /**
     * @param mixed $address_uid
     * @return AddressModel
     */
    public function setAddressUid($address_uid)
    {
        $this->address_uid = $address_uid;
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
     * @return AddressModel
     */
    public function setClientUid($client_uid)
    {
        $this->client_uid = $client_uid;
        return $this;
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
     * @return AddressModel
     */
    public function setApplicationUid($application_uid)
    {
        $this->application_uid = $application_uid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContactType()
    {
        return $this->contact_type;
    }

    /**
     * @param mixed $contact_type
     * @return AddressModel
     */
    public function setContactType($contact_type)
    {
        $this->contact_type = $contact_type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressLabel()
    {
        return $this->address_label;
    }

    /**
     * @param mixed $address_label
     * @return AddressModel
     */
    public function setAddressLabel($address_label)
    {
        $this->address_label = $address_label;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     * @return AddressModel
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     * @return AddressModel
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress1()
    {
        return $this->address_1;
    }

    /**
     * @param mixed $address_1
     * @return AddressModel
     */
    public function setAddress1($address_1)
    {
        $this->address_1 = $address_1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress2()
    {
        return $this->address_2;
    }

    /**
     * @param mixed $address_2
     * @return AddressModel
     */
    public function setAddress2($address_2)
    {
        $this->address_2 = $address_2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @param mixed $postcode
     * @return AddressModel
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     * @return AddressModel
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressNotes()
    {
        return $this->address_notes;
    }

    /**
     * @param mixed $address_notes
     * @return AddressModel
     */
    public function setAddressNotes($address_notes)
    {
        $this->address_notes = $address_notes;
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
     * @return AddressModel
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
     * @return AddressModel
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
     * @return AddressModel
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }



}
