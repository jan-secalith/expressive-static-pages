<?php

declare(strict_types=1);

namespace Stock\Model;

use Common\Model\CommonModelInterface;

class StockModel implements CommonModelInterface
{

    const STOCK_STATUS_NEW = 0;
    const STOCK_STATUS_REMOVED = 1;
    const STOCK_STATUS_DISABLED = 2;
    const STOCK_STATUS_ENABLED = 3;
    const STOCK_STATUS_ARCHIVED = 4;

    const STOCK_STATUS_PATHS = [
        self::STOCK_STATUS_NEW => [
            self::STOCK_STATUS_DISABLED,
            self::STOCK_STATUS_ENABLED,
        ],
        self::STOCK_STATUS_DISABLED => [
            self::STOCK_STATUS_REMOVED,
            self::STOCK_STATUS_ARCHIVED,
            self::STOCK_STATUS_ENABLED,
        ],
        self::STOCK_STATUS_ENABLED => [
            self::STOCK_STATUS_REMOVED,
            self::STOCK_STATUS_ARCHIVED,
            self::STOCK_STATUS_DISABLED,
        ],
        self::STOCK_STATUS_REMOVED => [
            self::STOCK_STATUS_DISABLED,
            self::STOCK_STATUS_ARCHIVED,
        ],
        self::STOCK_STATUS_ARCHIVED => [
            self::STOCK_STATUS_DISABLED,
            self::STOCK_STATUS_REMOVED,
        ],
    ];

    public $stock_uid;
    public $product_uid;
    public $barcode_uid;
    public $product_qty;
    public $stock_status;
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
        $this->barcode_uid = (!empty($data['barcode_uid'])) ? $data['barcode_uid'] : null;
        $this->product_qty = (!empty($data['product_qty'])) ? $data['product_qty'] : null;
        $this->stock_status = (!empty($data['stock_status'])) ? $data['stock_status'] : null;
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
        if ($this->barcode_uid !== null) {
            $data['barcode_uid'] = $this->barcode_uid;
        }
        if ($this->product_qty !== null) {
            $data['product_qty'] = $this->product_qty;
        }
        if ($this->stock_status !== null) {
            $data['stock_status'] = $this->stock_status;
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
     * @return StockModel
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
     * @return StockModel
     */
    public function setProductUid($product_uid)
    {
        $this->product_uid = $product_uid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBarcodeUid()
    {
        return $this->barcode_uid;
    }

    /**
     * @param mixed $barcode_uid
     * @return StockModel
     */
    public function setBarcodeUid($barcode_uid)
    {
        $this->barcode_uid = $barcode_uid;
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
     * @return StockModel
     */
    public function setProductQty($product_qty)
    {
        $this->product_qty = $product_qty;
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
     * @return StockModel
     */
    public function setStockStatus($stock_status)
    {
        $this->stock_status = $stock_status;
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
     * @return StockModel
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
     * @return StockModel
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

}
