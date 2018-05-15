<?php

declare(strict_types=1);

namespace Stock\Model;

use Common\Model\CommonModelInterface;

class ProductStockModel implements CommonModelInterface
{
    public $stock_uid;
    public $product_uid;
    public $product_qty;
    public $name;
    public $price;
    public $unit;
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
     * @return ProductStockModel
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
     * @return ProductStockModel
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
     * @return ProductStockModel
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
     * @return ProductStockModel
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
     * @return ProductStockModel
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
     * @return ProductStockModel
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
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
     * @return ProductStockModel
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
     * @return ProductStockModel
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
     * @return ProductStockModel
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

}
