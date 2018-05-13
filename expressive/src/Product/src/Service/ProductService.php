<?php
namespace Product\Service;

use Cart\Model\CartItemModel;
use Cart\Model\CartItemTable;
use Cart\Model\CartTable;
use Common\Helper\RouteHelper;
use CurrencyExchange\Service\CurrencyExchangeService;
use Product\Model\ProductTable;
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

    public function __construct(
        ProductTable $productTable = null
    )
    {
        $this->productTable = $productTable;
    }

    /**
     *
     *
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function getItems()
    {
        $cartProducts = $this->productTable->fetchAll();

        if (!empty($cartProducts)) {
            return $cartProducts;
        }

        return null;
    }

    /**
     * Returns cartProduct by cartId and productId
     *
     * @param $id
     * @return \Product\Model\ProductModel
     */
    public function getItem($productId)
    {
        return $this->productTable->getItem($productId);
    }
}
