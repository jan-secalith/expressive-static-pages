<?php

declare(strict_types=1);

namespace Stock\Handler;

use Common\Paginator\PaginatorAwareInterface;
use Common\Paginator\PaginatorAwareTrait;
use Stock\Service\StockServiceAwareTrait;
use Product\Service\ProductService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Stock\Form\StockBarcodeForm;
use Stock\Service\StockService;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Paginator\Paginator;
use Zend\Paginator\ScrollingStyle\Sliding;

class StockListHandler implements RequestHandlerInterface, PaginatorAwareInterface
{
    use PaginatorAwareTrait;

    private $containerName;

    private $router;

    private $template;

    private $productService;

    private $stockService;

    private $urlHelper;

    public function __construct(
        Router\RouterInterface $router,
        Template\TemplateRendererInterface $template = null,
        string $containerName,
        ProductService $productService = null,
        StockService $stockService = null,
        UrlHelper $urlHelper = null,
        Paginator $paginator = null
    ) {
        $this->router        = $router;
        $this->template      = $template;
        $this->containerName = $containerName;
        $this->productService = $productService;
        $this->stockService = $stockService;
        $this->setPaginator($paginator);
        $this->urlHelper = $urlHelper;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $data = null;

        $data['layout'] = 'restable-stock-layout::restable-stock';

        $productList = $this->productService->getItems();

        $data['stock_list'] = $this->stockService->getAllFull();

        $this->getPaginator()
            ->setCurrentPageNumber($request->getAttribute('page'))
            ->setDefaultItemCountPerPage(5)
        ;
        $data['paginator'] = $this->getPaginator();

        if(strtoupper($request->getMethod())==="POST") {
            $postData = $request->getParsedBody();

            $data['stock_list'] = $this->stockService->search($postData->getStockBarcode());

        }
        $data['list'] = $productList;

        $data['forms']['stock_barcode_form'] = $this->getStockBarcodeForm();

        return new HtmlResponse($this->template->render('stock::stock-list', $data));
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
