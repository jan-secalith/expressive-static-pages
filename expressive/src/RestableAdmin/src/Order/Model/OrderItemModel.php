<?php

declare(strict_types=1);

namespace Order\Model;

class OrderItemModel
{
    public $order_id;
    public $product_id;
    public $product_qty;
    public $price_unit;
    public $updated;
    public $currency_code;

    /**
     * CartItemModel constructor.
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
     * @return OrderItemModel
     */
    public function exchangeArray(array $data = [])
    {
        $this->order_id = (!empty($data['order_id'])) ? $data['order_id'] : null;
        $this->product_id = (!empty($data['product_id'])) ? $data['product_id'] : null;
        $this->product_qty = (!empty($data['product_qty'])) ? $data['product_qty'] : null;
        $this->price_unit = (!empty($data['price_unit'])) ? $data['price_unit'] : null;
        $this->updated = (!empty($data['updated'])) ? $data['updated'] : null;
        $this->currency_code = (!empty($data['currency_code'])) ? $data['currency_code'] : null;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [];
        if ($this->order_id !== null) {
            $data['order_id'] = $this->order_id;
        }
        if ($this->product_id !== null) {
            $data['product_id'] = $this->product_id;
        }
        if ($this->product_qty !== null) {
            $data['product_qty'] = $this->product_qty;
        }
        if ($this->price_unit !== null) {
            $data['price_unit'] = $this->price_unit;
        }
        if ($this->updated !== null) {
            $data['updated'] = $this->updated;
        }
        if ($this->currency_code !== null) {
            $data['currency_code'] = $this->currency_code;
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
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * @param mixed $order_id
     * @return OrderItemModel
     */
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
        return $this;
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
     * @return OrderItemModel
     */
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProductQty()
    {
        return $this->product_qty;
    }

    /**
     * @param mixed $product_qty
     * @return OrderItemModel
     */
    public function setProductQty($product_qty)
    {
        $this->product_qty = $product_qty;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPriceUnit()
    {
        return $this->price_unit;
    }

    /**
     * @param mixed $price_unit
     * @return OrderItemModel
     */
    public function setPriceUnit($price_unit)
    {
        $this->price_unit = $price_unit;
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
     * @return OrderItemModel
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrencyCode()
    {
        return $this->currency_code;
    }

    /**
     * @param mixed $currency_code
     * @return OrderItemModel
     */
    public function setCurrencyCode($currency_code)
    {
        $this->currency_code = $currency_code;
        return $this;
    }

}
