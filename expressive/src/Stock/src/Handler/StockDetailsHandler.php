<?php

declare(strict_types=1);

namespace Stock\Handler;

use Common\Handler\DataAwareInterface;
use Common\Handler\DataAwareTrait;
use Product\Service\ProductService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Stock\Form\StockBarcodeForm;
use Stock\Service\StockService;
use Stock\Service\StockServiceAwareInterface;
use Stock\Service\StockServiceAwareTrait;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Router;
use Zend\Expressive\Template;

class StockDetailsHandler implements RequestHandlerInterface, StockServiceAwareInterface, DataAwareInterface
{

    use StockServiceAwareTrait;
    use DataAwareTrait;

    private $containerName;

    private $router;

    private $template;

    private $productService;

    private $urlHelper;

    private $currentProductUid;

    public function __construct(
        Router\RouterInterface $router,
        Template\TemplateRendererInterface $template = null,
        string $containerName,
        ProductService $productService = null,
        StockService $stockService = null,
        UrlHelper $urlHelper = null
    ) {
        $this->router        = $router;
        $this->template      = $template;
        $this->containerName = $containerName;
        $this->productService = $productService;
        $this->setStockService($stockService);
        $this->urlHelper = $urlHelper;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $data = null;

        $this->currentProductUid = $request->getAttribute('product_uid');

        $this->addData('restable-stock-layout::restable-stock','layout');


        $this->addData($this->productService->getItem($this->currentProductUid),'product_data');
        $this->addData($this->getStockService()->getItem($this->currentProductUid),'stock_data');
        $this->addData($this->getStockService()->getBarcodeItemByProductUid($this->currentProductUid),'barcode_data');
        $this->addData($this->getStockService()->getStatusByProductUid($this->currentProductUid)->firstItem(),'status_data');


        return new HtmlResponse($this->template->render('stock::stock-product-details', $this->getData()));
    }

    /**
     * @return StockBarcodeForm
     */
    private function getStockBarcodeForm()
    {
        $form = new StockBarcodeForm();
        $form->setAttribute('action', $this->urlHelper->generate('stock.product.list'));

        return $form;
    }
}
