<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Product\Model;

class ProductModel
{
    public $product_id;
    public $name;
    public $price;
    public $unit;
    public $description_short;

    /**
     * ProductModel constructor.
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
     * @return ProductModel
     */
    public function exchangeArray(array $data = [])
    {
        $this->product_id = ( ! empty($data['product_id']) ) ? $data['product_id'] : null;
        $this->name = ( ! empty($data['name']) ) ? $data['name'] : null;
        $this->price = ( ! empty($data['price']) ) ? $data['price'] : null;
        $this->unit = ( ! empty($data['unit']) ) ? $data['unit'] : null;
        $this->description_short = ( ! empty($data['description_short']) ) ? $data['description_short'] : null;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [];
        if ($this->product_id !== null) {
            $data['product_id'] = $this->product_id;
        }
        if ($this->name !== null) {
            $data['name'] = $this->name;
        }
        if ($this->price !== null) {
            $data['price'] = $this->price;
        }
        if ($this->unit !== null) {
            $data['unit'] = $this->unit;
        }
        if ($this->description_short !== null) {
            $data['description_short'] = $this->description_short;
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
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * @param mixed $product_id
     * @return ProductModel
     */
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return ProductModel
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     * @return ProductModel
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param mixed $unit
     * @return ProductModel
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescriptionShort()
    {
        return $this->description_short;
    }

    /**
     * @param mixed $description_short
     * @return ProductModel
     */
    public function setDescriptionShort($description_short)
    {
        $this->description_short = $description_short;
        return $this;
    }
}