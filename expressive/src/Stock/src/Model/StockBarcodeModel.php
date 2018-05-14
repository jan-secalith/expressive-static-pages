<?php

declare(strict_types=1);

namespace Stock\Model;

use Common\Model\CommonModelInterface;

class StockBarcodeModel implements CommonModelInterface
{
    public $product_uid;
    public $barcode_value;
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
        $this->product_uid = (!empty($data['product_uid'])) ? $data['product_uid'] : null;
        $this->barcode_value = (!empty($data['barcode_value'])) ? $data['barcode_value'] : null;
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
        if ($this->product_uid !== null) {
            $data['product_uid'] = $this->product_uid;
        }
        if ($this->barcode_value !== null) {
            $data['barcode_value'] = $this->barcode_value;
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
    public function getProductUid()
    {
        return $this->product_uid;
    }

    /**
     * @param mixed $product_uid
     * @return StockBarcodeModel
     */
    public function setProductUid($product_uid)
    {
        $this->product_uid = $product_uid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBarcodeValue()
    {
        return $this->barcode_value;
    }

    /**
     * @param mixed $barcode_value
     * @return StockBarcodeModel
     */
    public function setBarcodeValue($barcode_value)
    {
        $this->barcode_value = $barcode_value;
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
     * @return StockBarcodeModel
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
     * @return StockBarcodeModel
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

}
