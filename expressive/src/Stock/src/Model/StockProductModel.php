<?php

declare(strict_types=1);

namespace Stock\Model;

use Common\Model\CommonModelInterface;

class StockProductModel implements CommonModelInterface
{
    public $stock_uid;
    public $product_uid;
    public $product_qty;
    public $name;
    public $price;
    public $unit;
    public $stock_status;
    public $status_code;
    public $status;
    public $barcodes;
    public $updated;
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
        $this->stock_uid = (!empty($data['stock_uid'])) ? $data['stock_uid'] : null;
        $this->product_uid = (!empty($data['product_uid'])) ? $data['product_uid'] : null;
        $this->product_qty = (!empty($data['product_qty'])) ? $data['product_qty'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->price = (!empty($data['price'])) ? $data['price'] : null;
        $this->unit = (!empty($data['unit'])) ? $data['unit'] : null;
        $this->stock_status = (!empty($data['stock_status'])||is_numeric($data['stock_status'])) ? $data['stock_status'] : null;
        $this->status_code = (!empty($data['status_code'])||is_numeric($data['status_code'])) ? $data['status_code'] : null;
        $this->status = (!empty($data['status'])) ? $data['status'] : null;
        $this->barcodes = (!empty($data['barcodes'])) ? $data['barcodes'] : null;
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
        if ($this->stock_uid !== null) {
            $data['stock_uid'] = $this->stock_uid;
        }
        if ($this->product_uid !== null) {
            $data['product_uid'] = $this->product_uid;
        }
        if ($this->product_qty !== null) {
            $data['product_qty'] = $this->product_qty;
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
        if ($this->stock_status !== null) {
            $data['stock_status'] = $this->stock_status;
        }
        if ($this->status_code !== null) {
            $data['status_code'] = $this->stock_status;
        }
        if ($this->status !== null) {
            $data['status'] = $this->status;
        }
        if ($this->barcodes !== null) {
            $data['barcodes'] = $this->barcodes;
        }
        if ($this->updated !== null) {
            $data['updated'] = $this->updated;
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

    /**
     * @return mixed
     */
    public function getStockUid()
    {
        return $this->stock_uid;
    }

    /**
     * @param mixed $stock_uid
     * @return StockProductModel
     */
    public function setStockUid($stock_uid)
    {
        $this->stock_uid = $stock_uid;
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
     * @return StockProductModel
     */
    public function setProductUid($product_uid)
    {
        $this->product_uid = $product_uid;
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
     * @return StockProductModel
     */
    public function setProductQty($product_qty)
    {
        $this->product_qty = $product_qty;
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
     * @return StockProductModel
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
     * @return StockProductModel
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
     * @return StockProductModel
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStockStatus()
    {
        return $this->stock_status;
    }

    /**
     * @param mixed $stock_status
     * @return StockProductModel
     */
    public function setStockStatus($stock_status)
    {
        $this->stock_status = $stock_status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->status_code;
    }

    /**
     * @param mixed $status_code
     * @return StockProductModel
     */
    public function setStatusCode($status_code)
    {
        $this->status_code = $status_code;
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
     * @return StockProductModel
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBarcodes()
    {
        return $this->barcodes;
    }

    /**
     * @param mixed $barcodes
     * @return StockProductModel
     */
    public function setBarcodes($barcodes)
    {
        $this->barcodes = $barcodes;
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
     * @return StockProductModel
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
     * @return StockProductModel
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

}
