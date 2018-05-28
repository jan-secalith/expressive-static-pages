<?php

declare(strict_types=1);

namespace Stock\Model;

use Common\Model\CommonModelInterface;

/**
 * Uses Contstants as those data never changes;
 *
 * Class StockStatusModel
 * @package Stock\Model
 */
class StockStatusModel implements CommonModelInterface
{

    const STOCK_STATUS_DEFAULT = 'default';
    const STOCK_STATUS_NEW = 0;
    const STOCK_STATUS_REMOVED = 1;
    const STOCK_STATUS_DISABLED = 2;
    const STOCK_STATUS_ENABLED = 3;
    const STOCK_STATUS_ARCHIVED = 4;

    const STOCK_STATUS_NEW_NOT_SPECIFIED_LABEL = "Unspecified";
    const STOCK_STATUS_NEW_LABEL = "New";
    const STOCK_STATUS_REMOVED_LABEL = "Removed";
    const STOCK_STATUS_DISABLED_LABEL = "Disabled";
    const STOCK_STATUS_ENABLED_LABEL = "Enabled";
    const STOCK_STATUS_ARCHIVED_LABEL = "Archived";

    const STOCK_STATUS_PATHS = [
        self::STOCK_STATUS_DEFAULT => self::STOCK_STATUS_NEW,
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

    public static function getStatusAll($include_default = false)
    {
        // Inlcude default option if permitted:
        $statuses=($include_default!==false&&$include_default!==null)?['default'=>self::STOCK_STATUS_NEW_NOT_SPECIFIED_LABEL]:[];

        $statuses[self::STOCK_STATUS_NEW] = self::STOCK_STATUS_NEW_LABEL;
        $statuses[self::STOCK_STATUS_REMOVED] = self::STOCK_STATUS_REMOVED_LABEL;
        $statuses[self::STOCK_STATUS_DISABLED] = self::STOCK_STATUS_DISABLED_LABEL;
        $statuses[self::STOCK_STATUS_ENABLED] = self::STOCK_STATUS_ENABLED_LABEL;
        $statuses[self::STOCK_STATUS_ARCHIVED] = self::STOCK_STATUS_ARCHIVED_LABEL;

        return $statuses;
    }

    /**
     * Returns (bool)false if status is invalid.
     *
     * @param $status
     * @return bool
     */
    public function getStatusAvailable($status=self::STOCK_STATUS_DEFAULT)
    {
        $status = is_numeric($status)?(int)$status:$status;
        if( ! array_key_exists($status,self::STOCK_STATUS_PATHS)) {
            return false;
        } else {
            $statusAll = $this->getStatusAll(false);
            $status = ($status===self::STOCK_STATUS_DEFAULT)?self::STOCK_STATUS_PATHS[self::STOCK_STATUS_DEFAULT]:$status;
            $statusAvailable = self::STOCK_STATUS_PATHS[$status];

            return $statusAvailable;
        }
    }

    public function getStatusAvailableWithLabels($status=self::STOCK_STATUS_DEFAULT,$preserveDefault=false)
    {
        $output = [];
        if( ! $preserveDefault && ! is_numeric($status)) {

        } else {
            $status = (int) $status;
        }
        $statusAvailable = $this->getStatusAvailable($status);
        $statusAllWithLabels = self::getStatusAll();
        foreach($statusAvailable as $statusCode) {
            $output[(int)$statusCode] = $statusAllWithLabels[$statusCode];
        }

        return $output;
    }

    public static function getStatusCurrentWithLabel($status=self::STOCK_STATUS_DEFAULT)
    {
        $stockPaths = (is_string(self::STOCK_STATUS_PATHS[$status]))
            ? self::STOCK_STATUS_PATHS[self::STOCK_STATUS_PATHS[$status]]
            : self::STOCK_STATUS_PATHS[$status]
        ;


        $statusAll = self::getStatusAll(true);

        return [$status=>$statusAll[$status]];

var_dump(self::STOCK_STATUS_PATHS[$status]);
var_dump($status);
var_dump(self::STOCK_STATUS_PATHS[self::STOCK_STATUS_PATHS[$status]]);
var_dump($stockPaths);
        $status = ( ! is_numeric($status)&&in_array($status,$stockPaths))
            ?(int) key($stockPaths)
            :(int) $status;
//        var_dumP($stockPaths[$status]);
//        var_dumP(in_array($status,$stockPaths));
//        if( ! in_array($status,$stockPaths)) {
//            var_dump($status);
//            var_dump($stockPaths);die();
//            return false;
//        }

        $statusAll = self::getStatusAll(false);
//var_dump($statusAll);
        $status = ($status===self::STOCK_STATUS_DEFAULT)?$stockPaths[self::STOCK_STATUS_DEFAULT]:$status;

        return [$status=>$statusAll[$status]];
    }

    public $product_uid;
    public $stock_uid;
    public $status_code;
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
        $this->stock_uid = (!empty($data['stock_uid'])) ? $data['stock_uid'] : null;
        $this->status_code = ( ! empty($data['status_code']) || is_numeric($data['status_code'])) ? $data['status_code'] : null;
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
        if ($this->stock_uid !== null) {
            $data['stock_uid'] = $this->stock_uid;
        }
        if ($this->status_code !== null) {
            $data['status_code'] = $this->status_code;
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
    public function getStockUid()
    {
        return $this->stock_uid;
    }

    /**
     * @param mixed $stock_uid
     * @return StockStatusModel
     */
    public function setStockUid($stock_uid)
    {
        $this->stock_uid = $stock_uid;
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
     * @return StockStatusModel
     */
    public function setStatusCode($status_code)
    {
        $this->status_code = $status_code;
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
