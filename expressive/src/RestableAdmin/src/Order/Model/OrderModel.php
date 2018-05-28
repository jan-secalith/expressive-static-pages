<?php

declare(strict_types=1);

namespace RestableAdmin\Order\Model;

use Common\Model\CommonModelInterface;

class OrderModel implements CommonModelInterface
{
    public $order_id;
    public $cart_id;
    public $currency_code;
    public $total;
    public $status;
    public $updated;

    public const ORDER_STATUS_QUOTE = 0;
    public const ORDER_STATUS_COMFIRMED = 1;
    public const ORDER_STATUS_REJECTED = 2;
    public const ORDER_STATUS_PROCESSING = 3;
    public const ORDER_STATUS_DELIVERY = 4;
    public const ORDER_STATUS_COMPLETE = 5;

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
        $this->order_id = (!empty($data['order_id'])) ? $data['order_id'] : null;
        $this->cart_id = (!empty($data['cart_id'])) ? $data['cart_id'] : null;
        $this->currency_code = (!empty($data['currency_code'])) ? $data['currency_code'] : null;
        $this->total = (!empty($data['total'])) ? $data['total'] : null;
        $this->status = (!empty($data['status'])) ? $data['status'] : null;
        $this->updated = (!empty($data['updated'])) ? $data['updated'] : null;

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
        if ($this->cart_id !== null) {
            $data['cart_id'] = $this->cart_id;
        }
        if ($this->currency_code !== null) {
            $data['currency_code'] = $this->currency_code;
        }
        if ($this->total !== null) {
            $data['total'] = $this->total;
        }
        if ($this->status !== null) {
            $data['status'] = $this->status;
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
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * @param mixed $order_id
     * @return OrderModel
     */
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCartId()
    {
        return $this->cart_id;
    }

    /**
     * @param mixed $cart_id
     * @return OrderModel
     */
    public function setCartId($cart_id)
    {
        $this->cart_id = $cart_id;
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
     * @return OrderModel
     */
    public function setCurrencyCode($currency_code)
    {
        $this->currency_code = $currency_code;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     * @return OrderModel
     */
    public function setTotal($total)
    {
        $this->total = $total;
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
     * @return OrderModel
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
     * @return OrderModel
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }

}
