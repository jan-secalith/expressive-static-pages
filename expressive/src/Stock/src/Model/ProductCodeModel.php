<?php

declare(strict_types=1);

namespace Stock\Model;

use Common\Model\CommonModelInterface;

class ProductCodeModel implements CommonModelInterface
{
    public $product_id;
    public $code;

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
        $this->product_id = (!empty($data['product_id'])) ? $data['product_id'] : null;
        $this->code = (!empty($data['code'])) ? $data['code'] : null;

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
        if ($this->code !== null) {
            $data['code'] = $this->code;
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
     * @return ProductCodeModel
     */
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     * @return ProductCodeModel
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

}
