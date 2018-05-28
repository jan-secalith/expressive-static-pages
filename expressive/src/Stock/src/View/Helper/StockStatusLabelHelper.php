<?php

declare(strict_types=1);

namespace Stock\View\Helper;

use Stock\Model\StockStatusModel;
use Zend\View\Helper\AbstractHelper;

class StockStatusLabelHelper extends AbstractHelper
{
    protected $cartService;

    protected $badges = [
        StockStatusModel::STOCK_STATUS_NEW=>'badge badge-primary'
    ];

    public function __invoke($status=0,$decorate=false)
    {
        $statusLabel = StockStatusModel::getStatusCurrentWithLabel($status);

        if( $decorate && in_array((int)$status,$this->badges)) {
            return sprintf('<div class="%s">%s</div>',$this->badges[$status],$statusLabel[$status]);
        }

        return (is_string($statusLabel))?$statusLabel:$statusLabel[$status];

    }
}
