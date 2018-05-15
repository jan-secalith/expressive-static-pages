<?php

declare(strict_types=1);

namespace Stock\Handler;

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

class ProductListHandler implements RequestHandlerInterface
{
    private $containerName;

    private $router;

    private $template;

    private $productService;

    private $stockService;

    private $urlHelper;

    private $paginator;

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
        $this->paginator = $paginator;
        $this->urlHelper = $urlHelper;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $data = null;

        $currentPage = $request->getAttribute('page');
        $this->paginator->setCurrentPageNumber($currentPage);
        $this->paginator->setDefaultItemCountPerPage(10);

//        $data['layout'] = 'layout::default';

        $data['layout'] = 'restable-stock-layout::restable-stock';

        $productList = $this->productService->getItems();

        $data['stock_list'] = $this->stockService->getAllFull();

        $data['paginator'] = $this->paginator;

        if(strtoupper($request->getMethod())==="POST") {
            $postData = $request->getParsedBody();

            $data['stock_list'] = $this->stockService->search($postData->getStockBarcode());

        } elseif (1==2 /*false !== $prgData || ! empty($prgData)*/) {
//            var_dump($prgData);
//            $postData = $prgData;
        } else {
            $postData = [];
        }
        $data['list'] = $productList;

        $data['forms']['stock_barcode_form'] = $this->getStockBarcodeForm();

//        $flashMessages = $request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);
//        $data['messages'] = $flashMessages->getFlashes();

        return new HtmlResponse($this->template->render('stock::stock-list', $data));
    }

    /**
     * Use the `null` argument if want an empty form
     *
     * @param null $product
     * @return ItemAddForm
     */
    private function getFormCartProductAdd($product=null)
    {
        $form = new ItemAddForm();

        if($product !== null) {
            $form->setAttribute('action', $this->urlHelper->generate('cart.item.add'));
            $form->get('redirect_url')->setValue(
                $this->urlHelper->generate()
            );
            $form->get('product_id')->setValue($product->getProductId());
            $form->bind($product);
        }

        $form->setAttribute('method', 'POST');

        return $form;
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
