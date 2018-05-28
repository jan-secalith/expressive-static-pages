<?php

declare(strict_types=1);

namespace Stock\Model;

use Common\Model\CommonModelInterface;

class StockRemoveModel implements CommonModelInterface
{
    public $application_id;
    public $product_uid;
    public $stock_uid;
    public $stock_product_remove_confirm;

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
        $this->product_uid = (!empty($data['product_uid'])) ? $data['product_uid'] : null;
        $this->stock_uid = (!empty($data['stock_uid'])) ? $data['stock_uid'] : null;
        $this->stock_product_remove_confirm = (!empty($data['stock_product_remove_confirm'])) ? $data['stock_product_remove_confirm'] : null;

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
        if ($this->product_uid !== null) {
            $data['product_uid'] = $this->product_uid;
        }
        if ($this->stock_uid !== null) {
            $data['stock_uid'] = $this->stock_uid;
        }
        if ($this->stock_product_remove_confirm !== null) {
            $data['stock_product_remove_confirm'] = $this->stock_product_remove_confirm;
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
     * @return mixed
     */
    public function getProductUid()
    {
        return $this->product_uid;
    }

    /**
     * @param mixed $product_uid
     * @return StockRemoveModel
     */
    public function setProductUid($product_uid)
    {
        $this->product_uid = $product_uid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStockUid()
    {
        return $this->stock_uid;
    }

    /**
     * @param mixed $stock_uid
     * @return StockRemoveModel
     */
    public function setStockUid($stock_uid)
    {
        $this->stock_uid = $stock_uid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStockProductRemoveConfirm()
    {
        return $this->stock_product_remove_confirm;
    }

    /**
     * @param mixed $stock_product_remove_confirm
     * @return StockRemoveModel
     */
    public function setStockProductRemoveConfirm($stock_product_remove_confirm)
    {
        $this->stock_product_remove_confirm = $stock_product_remove_confirm;
        return $this;
    }

}
