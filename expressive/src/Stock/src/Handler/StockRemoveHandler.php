<?php

declare(strict_types=1);

namespace Stock\Handler;

use Common\Handler\DataAwareInterface;
use Common\Handler\DataAwareTrait;
use Product\Service\ProductService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Stock\Form\StockProductRemoveForm;
use Stock\Service\StockService;
use Stock\Service\StockServiceAwareInterface;
use Stock\Service\StockServiceAwareTrait;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Router;
use Zend\Expressive\Template;

class StockRemoveHandler implements RequestHandlerInterface, StockServiceAwareInterface, DataAwareInterface
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
        $this->addData('restable-stock-layout::restable-stock','layout');
        $messages = null;

        $this->currentProductUid = $request->getAttribute('product_uid');

        if($this->currentProductUid) {
            $this->addData($this->productService->getItem($this->currentProductUid),'product_data');
            $this->addData($this->getStockService()->getItem($this->currentProductUid),'stock_data');
            $this->addData($this->getStockService()->getBarcodeItemByProductUid($this->currentProductUid),'barcode_data');
        } else {
            echo 'error';
        }

        $this->addData($this->getRemoveForm(),'form');

        if(strtoupper($request->getMethod())==="POST") {
            // Form has been submitted. Assume SECOND step.

            $postData = $request->getParsedBody();

            $this->getData('form')->setData($postData);

            if ($this->getData('form')->isValid()) {
                // Form is valid
                $formData = $this->getData('form')->getData();

                if($formData->getStockProductRemoveConfirm() === 'yes') {
                    $rowsAffected = $this->getStockService()->changeStockProductStatus($formData);

                    if( $rowsAffected['rows_affected']['product'] > 0
                        || $rowsAffected['rows_affected']['stock'] > 0
                        || $rowsAffected['rows_affected']['barcode'] > 0
                    ) {
                        $messages['success'][] = 'Item has been updated.';
                        // Flash and Redirect



//                    return new RedirectResponse($this->urlHelper->generate('stock.product.list'));
                    } else {
                        $messages['info'][] = 'Data unchanged.';
                        $messages['info'][] = 'Item has NOT been removed.';
                    }



                } else {
                    #TODO flash and redirect
                    $messages['info'][] = 'Data unchanged.';
                    $messages['info'][] = 'Item has NOT been removed.';
                }

            } else {
                $messages['error'][] = 'Form seems to be invalid.';
                $messages['error'][] = 'Item has NOT been removed.';
            }

        } elseif($this->currentProductUid) {
            // assume First step.
            $model = new \Stock\Model\StockRemoveModel([
                'product_uid'=>$this->currentProductUid,
                'stock_uid'=>$this->getData('stock_data')->getStockUid(),
                'application_id'=>1,
            ]);

            $this->getData('form')->setData($model->toArray());
        }

        $this->addData($messages,'messages');

        return new HtmlResponse($this->template->render('stock::stock-product-remove', $this->getData()));
    }

    /**
     * @return StockRemoveForm
     */
    private function getRemoveForm()
    {
        $form = new StockProductRemoveForm();

        $form->setAttribute(
            'action',
            $this->urlHelper->generate(
                'stock.product.write.remove',
                ['product_uid'=>$this->currentProductUid]
            )
        );

        return $form;
    }
}
