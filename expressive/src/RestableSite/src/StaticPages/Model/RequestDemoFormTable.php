<?php

declare(strict_types=1);

namespace RestableSite\StaticPages\Model;

use Zend\Db\TableGateway\TableGateway;

class RequestDemoFormTable
{
    /**
     * @var TableGateway
     */
    protected $tableGateway;

    /**
     * ProductTable constructor.
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @param \Cart\Model\CartItemModel $item
     */
    public function saveItem($item)
    {
        $updated = new \DateTime('now');

        $data = [
            'cart_id' => $item->getCartId(),
            'product_id' => $item->getProductId(),
            'product_qty' => $item->getProductQty(),
            'price_unit' => $item->getPriceUnit(),
            'updated' => $updated->format('Y-m-d\TH:i:s.u'),
        ];
        $this->tableGateway->insert($data);
    }
}
