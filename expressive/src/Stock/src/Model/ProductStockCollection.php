<?php

declare(strict_types=1);

namespace Stock\Model;

use Zend\Paginator\Adapter\AdapterInterface;
use Zend\Paginator\Paginator;
use Zend\Paginator\ScrollingStyle\Sliding;

class ProductStockCollection implements AdapterInterface
{
    protected $items;

    public function __construct($items = [])
    {
        $this->items = $items;
    }

    public function count()
    {
        return count($this->items);
    }

    public function getItems($offset, $itemCountPerPage)
    {
        return array_slice($this->items, $offset, $itemCountPerPage);
    }
}