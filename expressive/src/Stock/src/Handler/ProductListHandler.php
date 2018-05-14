<?php

declare(strict_types=1);

namespace Stock\Handler;

use Common\Helper\RouteHelper;
use Cart\Form\ItemAddForm;
use Stock\Form\StockBarcodeForm;
use Cart\Service\CartService;
use Product\Service\ProductService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Expressive\Flash\FlashMessageMiddleware;

class ProductListHandler implements RequestHandlerInterface
{
    private $containerName;

    private $router;

    private $template;

    private $productService;

    private $urlHelper;

    protected $useCurrencyExchange;
    protected $useCurrencyExchangeForm;

    public function __construct(
        Router\RouterInterface $router,
        Template\TemplateRendererInterface $template = null,
        string $containerName,
        ProductService $productService = null,
        UrlHelper $urlHelper = null
    ) {
        $this->router        = $router;
        $this->template      = $template;
        $this->containerName = $containerName;
        $this->productService = $productService;
        $this->urlHelper = $urlHelper;

        $this->useCurrencyExchange = true;
        $this->useCurrencyExchangeForm = true;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $data = null;

//        $data['layout'] = 'layout::ecommerce';
        $data['layout'] = 'layout::default';

        $productList = $this->productService->getItems();

//        $prgData = $request->getAttribute('prg');

        if(strtoupper($request->getMethod())==="POST") {
            $postData = $request->getParsedBody();
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

        return new HtmlResponse($this->template->render('stock::product-list', $data));
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
