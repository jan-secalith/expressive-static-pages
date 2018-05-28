<?php

declare(strict_types=1);

namespace RestableAdmin\Category\Model;

use Common\Model\CommonModelInterface;

class CategoryModel implements CommonModelInterface
{
    public $category_uid;
    public $category_parent;
    public $label;
    public $created;
    public $status;
    public $updated;

    public const STATUS_NEW = 0;
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
        $this->category_uid = (!empty($data['category_uid'])) ? $data['category_uid'] : null;
        $this->category_parent = (!empty($data['category_parent'])) ? $data['category_parent'] : null;
        $this->label = (!empty($data['label'])) ? $data['label'] : null;
        $this->created = (!empty($data['created'])) ? $data['created'] : null;
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
        if ($this->category_uid !== null) {
            $data['category_uid'] = $this->category_uid;
        }
        if ($this->category_parent !== null) {
            $data['category_parent'] = $this->category_parent;
        }
        if ($this->created !== null) {
            $data['created'] = $this->created;
        }
        if ($this->label !== null) {
            $data['label'] = $this->label;
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
    public function getCategoryUid()
    {
        return $this->category_uid;
    }

    /**
     * @param mixed $category_uid
     * @return CategoryModel
     */
    public function setCategoryUid($category_uid)
    {
        $this->category_uid = $category_uid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategoryParent()
    {
        return $this->category_parent;
    }

    /**
     * @param mixed $category_parent
     * @return CategoryModel
     */
    public function setCategoryParent($category_parent)
    {
        $this->category_parent = $category_parent;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     * @return CategoryModel
     */
    public function setLabel($label)
    {
        $this->label = $label;
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
     * @return CategoryModel
     */
    public function setCreated($created)
    {
        $this->created = $created;
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
     * @return CategoryModel
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
     * @return CategoryModel
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }

}
