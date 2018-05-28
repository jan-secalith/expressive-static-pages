<?php

declare(strict_types=1);

namespace RestableAdmin\Category\Model;

use Common\Model\CommonModelInterface;

class CategoryWriteModel implements CommonModelInterface
{
    public $application_id;

    public $fieldset_category;


    public function __construct(array $data = [])
    {
        if (! empty($data)) {
            $this->exchangeArray($data);
        }
    }


    public function exchangeArray(array $data = [])
    {
        $this->application_id = (!empty($data['application_id'])) ? $data['application_id'] : null;
        $this->fieldset_category = (!empty($data['fieldset_category'])) ? $data['fieldset_category'] : null;

        return $this;
    }

    function toArray()
    {
        $data = [];
        if ($this->application_id !== null) {
            $data['application_id'] = $this->application_id;
        }
        if ($this->fieldset_category !== null) {
            $data['fieldset_category'] = $this->fieldset_category;
        }

        return $data;
    }

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

    public function getApplicationId()
    {
        return $this->application_id;
    }

    public function setApplicationId($application_id)
    {
        $this->application_id = $application_id;
        return $this;
    }

    public function getFieldsetCategory()
    {
        return $this->fieldset_category;
    }

    public function setFieldsetCategory( $fieldset_category): CategoryWriteModel
    {
        $this->fieldset_category = $fieldset_category;

        return $this;
    }

}
