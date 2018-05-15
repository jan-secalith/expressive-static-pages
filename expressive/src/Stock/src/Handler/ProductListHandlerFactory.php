<?php

declare(strict_types=1);

namespace Stock\Handler;

use Product\Service\ProductService;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Stock\Service\StockService;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Paginator\Paginator;
use Zend\Paginator\ScrollingStyle\Sliding;

class ProductListHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $router   = $container->get(RouterInterface::class);
        $template = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;

        $urlHelper = $container->get(UrlHelper::class);
        $productService = $container->get(ProductService::class);
        $stockService = $container->get(StockService::class);


        $tableGateway = $stockService->getStockTable()->getTableGateway();
        $sqlSelect = $tableGateway->getSql()->select();
        $sqlSelect->columns(array('stock_uid','product_qty'));
        $sqlSelect->join('product', 'product.product_uid = stock.product_uid', array('name','price','description_short','unit'), 'left');
        $paginator = new Paginator(new \Zend\Paginator\Adapter\DbSelect($sqlSelect,$tableGateway->getAdapter(),$tableGateway->getResultSetPrototype()));

        Paginator::setDefaultScrollingStyle(new Sliding());

        return new ProductListHandler(
            $router,
            $template,
            get_class($container),
            $productService,
            $stockService,
            $urlHelper,
            $paginator
        );
    }
}
