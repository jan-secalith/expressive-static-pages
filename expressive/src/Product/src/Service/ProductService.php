<?php


namespace Product\Service;

use Common\Helper\RouteHelper;
use Product\Model\ProductTable;
use Zend\Cache\Storage\Adapter\AbstractAdapter;
use Zend\Expressive\Helper\UrlHelper;

/**
 * Class CartService
 *
 * Works in context of the session
 *
 * @package Cart\Service
 */
class ProductService
{

    /**
     * @var ProductTable
     */
    protected $productTable;

    protected $cacheService;

    public function __construct(ProductTable $productTable = null, AbstractAdapter $cacheService = null)
    {
        $this->productTable = $productTable;
        $this->cacheService = $cacheService;
    }

    /**
     *
     *
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function getItems()
    {

        $cartProductsCached = $this->cacheService->getItem('product.getItems');

        if( $cartProductsCached !== null) {
            return $cartProductsCached;
        } else {
            $cartProducts = $this->productTable->fetchAll();

            if ( ! empty($cartProducts)) {
                $this->cacheService->setItem('product.getItems',$cartProducts);
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
