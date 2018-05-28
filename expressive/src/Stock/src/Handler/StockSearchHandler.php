<?php

declare(strict_types=1);

namespace Stock\Handler;

use Common\Handler\DataAwareInterface;
use Common\Handler\DataAwareTrait;
use Common\Paginator\PaginatorAwareInterface;
use Common\Paginator\PaginatorAwareTrait;
use Stock\Service\StockServiceAwareTrait;
use Stock\Service\StockServiceAwareInterface;
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

class StockSearchHandler implements
    RequestHandlerInterface,
    PaginatorAwareInterface,
    DataAwareInterface,
    StockServiceAwareInterface
{
    use PaginatorAwareTrait;
    use DataAwareTrait;
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
        $this->stockService = $stockService;
        $this->urlHelper = $urlHelper;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $data = null;

        $data['layout'] = 'restable-stock-layout::restable-stock';


        $tableGateway = $this->getStockService()->getStockTable()->getTableGateway();
        $sqlSelect = $tableGateway->getSql()->select();
        $sqlSelect->columns(array('stock_uid','product_qty','stock_status'));
        $sqlSelect->join('product', 'product.product_uid = stock.product_uid', array('name','price','description_short','unit','product_uid'), 'left');
        $sqlSelect->join('stock_status', 'stock_status.stock_uid = stock.stock_uid', array('status_code'), 'left');

        $paginator = new Paginator(
            new \Zend\Paginator\Adapter\DbSelect(
                $sqlSelect,
                $tableGateway->getAdapter(),
                $tableGateway->getResultSetPrototype()
            )
        );

        $this->setPaginator($paginator);


        $productList = $this->productService->getItems();

        $data['stock_list'] = $this->stockService->getAllFull();

        $this->getPaginator()
            ->setCurrentPageNumber($request->getAttribute('page'))
            ->setDefaultItemCountPerPage(5)
        ;
        $data['paginator'] = $this->getPaginator();

        if(strtoupper($request->getMethod())==="POST") {
            $postData = $request->getParsedBody();
var_dump($postData);die();
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
