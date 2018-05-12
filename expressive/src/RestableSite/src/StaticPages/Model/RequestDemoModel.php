<?php

declare(strict_types=1);

namespace RestableSite\StaticPages\Model;

use Common\Model\CommonModelInterface;

class RequestDemoModel implements CommonModelInterface
{
    public $id;
    public $application_id;
    public $name_first;
    public $name_last;
    public $contact_phone;
    public $contact_email;
    public $venue_name;
    public $work_title;
    public $country;
    public $ip;
    public $created;

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
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->application_id = (!empty($data['application_id'])) ? $data['application_id'] : null;
        $this->name_first = (!empty($data['name_first'])) ? $data['name_first'] : null;
        $this->name_last = (!empty($data['name_last'])) ? $data['name_last'] : null;
        $this->contact_phone = (!empty($data['contact_phone'])) ? $data['contact_phone'] : null;
        $this->contact_email = (!empty($data['contact_email'])) ? $data['contact_email'] : null;
        $this->venue_name = (!empty($data['venue_name'])) ? $data['venue_name'] : null;
        $this->work_title = (!empty($data['work_title'])) ? $data['work_title'] : null;
        $this->country = (!empty($data['country'])) ? $data['country'] : null;
        $this->ip = (!empty($data['ip'])) ? $data['ip'] : null;
        $this->created = (!empty($data['created'])) ? $data['created'] : null;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [];
        if ($this->id !== null) {
            $data['id'] = $this->id;
        }
        if ($this->application_id !== null) {
            $data['application_id'] = $this->application_id;
        }
        if ($this->name_first !== null) {
            $data['name_first'] = $this->name_first;
        }
        if ($this->name_last !== null) {
            $data['name_last'] = $this->name_last;
        }
        if ($this->contact_phone !== null) {
            $data['contact_phone'] = $this->contact_phone;
        }
        if ($this->contact_email !== null) {
            $data['contact_email'] = $this->contact_email;
        }
        if ($this->venue_name !== null) {
            $data['venue_name'] = $this->venue_name;
        }
        if ($this->work_title !== null) {
            $data['work_title'] = $this->work_title;
        }
        if ($this->country !== null) {
            $data['country'] = $this->country;
        }
        if ($this->ip !== null) {
            $data['ip'] = $this->ip;
        }
        if ($this->created !== null) {
            $data['created'] = $this->created;
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

}
