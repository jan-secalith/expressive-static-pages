<?php

declare(strict_types=1);

namespace Stock\Model;

use Common\Model\CommonModelInterface;

class StockWriteModel implements CommonModelInterface
{
    public $application_id;
    /**
     * @var \Product\Model\ProductModel|null
     */
    public $fieldset_product;
    public $fieldset_stock;

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
        $this->application_id = (!empty($data['application_id'])) ? $data['application_id'] : null;
        $this->fieldset_product = (!empty($data['fieldset_product'])) ? $data['fieldset_product'] : null;
        $this->fieldset_stock = (!empty($data['fieldset_stock'])) ? $data['fieldset_stock'] : null;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [];
        if ($this->application_id !== null) {
            $data['application_id'] = $this->application_id;
        }
        if ($this->fieldset_product !== null) {
            $data['fieldset_product'] = $this->fieldset_product;
        }
        if ($this->fieldset_stock !== null) {
            $data['fieldset_stock'] = $this->fieldset_stock;
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
    public function getApplicationId()
    {
        return $this->application_id;
    }

    /**
     * @param mixed $application_id
     * @return StockProductModel
     */
    public function setApplicationId($application_id)
    {
        $this->application_id = $application_id;
        return $this;
    }

    /**
     * @return \Product\Model\ProductModel|null
     */
    public function getFieldsetProduct()
    {
        return $this->fieldset_product;
    }

    /**
     * @param mixed $fieldset_product
     * @return StockProductModel
     */
    public function setFieldsetProduct($fieldset_product)
    {
        $this->fieldset_product = $fieldset_product;
        return $this;
    }

    /**
     * @return \Stock\Model\StockModel|null
     */
    public function getFieldsetStock()
    {
        return $this->fieldset_stock;
    }

    /**
     * @param mixed $fieldset_stock
     * @return StockWriteModel
     */
    public function setFieldsetStock($fieldset_stock)
    {
        $this->fieldset_stock = $fieldset_stock;
        return $this;
    }
}
