<?php

declare(strict_types=1);

namespace Stock\Handler;

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

class StockDetailsHandler implements RequestHandlerInterface, StockServiceAwareInterface
{

    use StockServiceAwareTrait;

    private $containerName;

    private $router;

    private $template;

    private $productService;

    private $urlHelper;

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

        $data['layout'] = 'restable-stock-layout::restable-stock';

        $requestedProductUid = $request->getAttribute('product_uid');

        $data['product_data'] = $this->productService->getItem($requestedProductUid);

        $data['stock_data'] = $this->getStockService()->getItem($requestedProductUid);

        $data['barcode_data'] = $this->getStockService()->getBarcodeItemByProductUid($requestedProductUid)->getItems();

        return new HtmlResponse($this->template->render('stock::stock-product-details', $data));
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
