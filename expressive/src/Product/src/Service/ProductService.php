<?php

declare(strict_types=1);

namespace Product\Service;

use Common\Service\CacheServiceAwareInterface;
use Common\Service\CacheServiceAwareTrait;
use Product\Model\ProductTable;
use Zend\Cache\Storage\Adapter\AbstractAdapter;

/**
 * Class CartService
 *
 * Works in context of the session
 *
 * @package Cart\Service
 */
class ProductService implements CacheServiceAwareInterface
{
    use CacheServiceAwareTrait;

    /**
     * @var ProductTable
     */
    protected $productTable;


    public function __construct(ProductTable $productTable = null, AbstractAdapter $cacheService = null)
    {
        $this->productTable = $productTable;
        $this->setCacheService($cacheService);
    }

    /**
     *
     *
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function getItems()
    {

        $cartProductsCached = $this->getCacheService()->getItem('product.getItems');

        if( $cartProductsCached !== null) {
            return $cartProductsCached;
        } else {
            $cartProducts = $this->productTable->fetchAll();

            if ( ! empty($cartProducts)) {
                $this->getCacheService()->setItem('product.getItems',$cartProducts);
                return $cartProducts;
            }

            return null;
        }
    }


    public function getItem($productId)
    {
        return $this->productTable->getItem($productId);
    }
}
