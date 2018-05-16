<?php

declare(strict_types=1);

namespace Stock\Handler;

use Product\Service\ProductService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Stock\Form\ScanBarcodeInForm;
use Stock\Form\StockBarcodeForm;
use Stock\Service\StockService;
use Stock\Service\StockServiceAwareInterface;
use Stock\Service\StockServiceAwareTrait;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Router;
use Zend\Expressive\Template;

class ScanInHandler implements RequestHandlerInterface, StockServiceAwareInterface
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
        $this->stockService = $stockService;
        $this->urlHelper = $urlHelper;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $data = null;
        $messages = null;

        $data['layout'] = 'restable-stock-layout::restable-stock';

        $barcodeForm = $this->getStockBarcodeForm();

        if(strtoupper($request->getMethod())==="POST") {
            $postData = $request->getParsedBody();

            $barcodeForm->setData($postData);

            if($barcodeForm->isValid()) {

                $barcodeData = $barcodeForm->getData();

                $this->getStockService()->stockIncrease(
                    $barcodeData['stock_barcode'],
                    $barcodeData['stock_qty']
                );

                $messages = [
                    'success'=>[
                     "Product Quantity has been increased.",
                    ]
                ];

                if($barcodeForm->get('keep_qty')->getValue() === 'yes') {
                    $barcodeForm = $this->getStockBarcodeForm();
                    $barcodeForm->get('stock_qty')
                        ->setValue($barcodeData['stock_qty']);
                    $barcodeForm->get('keep_qty')
                        ->setChecked("yes");
                } else {
                    $barcodeForm = $this->getStockBarcodeForm();
                    $barcodeForm->get('stock_qty')
                        ->setValue(1);
                }

            } else {
//                $messages['form'] = $barcodeForm->getMessages();
            }

        }

        $data['messages'] = $messages;
        $data['forms']['stock_barcode_form'] = $barcodeForm;

        return new HtmlResponse($this->template->render('stock::scan-in', $data));
    }

    /**
     * @return StockBarcodeForm
     */
    private function getStockBarcodeForm()
    {
        $form = new ScanBarcodeInForm();
        $form->setAttribute('action', $this->urlHelper->generate('stock.scan.in.post'));

        return $form;
    }
}
