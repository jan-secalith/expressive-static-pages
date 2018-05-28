<?php

declare(strict_types=1);

namespace RestableAdmin\Contact\Model;

class ContactModel
{
    public $contact_name;
    public $contact_uid;
    public $client_uid;
    public $contact_email;
    public $contact_phone;
    public $contact_notes;
    public $status;
    public $updated;
    public $created;

    public const STATUS_NEW = 0;
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
        $this->contact_name = (!empty($data['contact_name'])) ? $data['contact_name'] : null;
        $this->contact_uid = (!empty($data['contact_uid'])) ? $data['contact_uid'] : null;
        $this->client_uid = (!empty($data['client_uid'])) ? $data['client_uid'] : null;
        $this->contact_email = (!empty($data['contact_email'])) ? $data['contact_email'] : null;
        $this->contact_phone = (!empty($data['contact_phone'])) ? $data['contact_phone'] : null;
        $this->contact_notes = (!empty($data['contact_notes'])) ? $data['contact_notes'] : null;
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
        if ($this->contact_name !== null) {
            $data['contact_name'] = $this->contact_name;
        }
        if ($this->contact_uid !== null) {
            $data['contact_uid'] = $this->contact_uid;
        }
        if ($this->client_uid !== null) {
            $data['client_uid'] = $this->client_uid;
        }
        if ($this->contact_email !== null) {
            $data['contact_email'] = $this->contact_email;
        }
        if ($this->contact_phone !== null) {
            $data['contact_phone'] = $this->contact_phone;
        }
        if ($this->status !== null) {
            $data['status'] = $this->status;
        }
        if ($this->contact_notes !== null) {
            $data['contact_notes'] = $this->contact_notes;
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
    public function getContactName()
    {
        return $this->contact_name;
    }

    /**
     * @return mixed
     */
    public function getContactUid()
    {
        return $this->contact_uid;
    }

    /**
     * @param mixed $contact_uid
     * @return ContactModel
     */
    public function setContactUid($contact_uid)
    {
        $this->contact_uid = $contact_uid;
        return $this;
    }

    /**
     * @param mixed $contact_name
     * @return ClientModel
     */
    public function setContactName($contact_name)
    {
        $this->contact_name = $contact_name;
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
     * @return ClientModel
     */
    public function setClientUid($client_uid)
    {
        $this->client_uid = $client_uid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContactEmail()
    {
        return $this->contact_email;
    }

    /**
     * @param mixed $contact_email
     * @return ClientModel
     */
    public function setContactEmail($contact_email)
    {
        $this->contact_email = $contact_email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContactPhone()
    {
        return $this->contact_phone;
    }

    /**
     * @param mixed $contact_phone
     * @return ClientModel
     */
    public function setContactPhone($contact_phone)
    {
        $this->contact_phone = $contact_phone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContactNotes()
    {
        return $this->contact_notes;
    }

    /**
     * @param mixed $contact_notes
     * @return ClientModel
     */
    public function setContactNotes($contact_notes)
    {
        $this->contact_notes = $contact_notes;
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
     * @return ClientModel
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
