<?php

declare(strict_types=1);

namespace Stock\Handler;

use Common\Handler\DataAwareInterface;
use Common\Handler\DataAwareTrait;
use Product\Service\ProductService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Stock\Form\StockProductForm;
use Stock\Service\StockService;
use Stock\Service\StockServiceAwareInterface;
use Stock\Service\StockServiceAwareTrait;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Router;
use Zend\Expressive\Template;

class StockWriteHandler implements RequestHandlerInterface, StockServiceAwareInterface, DataAwareInterface
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
            $this->addData($this->getStockService()->getStatusByProductUid($this->currentProductUid),'status_data');
        }


        // form needs the available statstues to be injected
        #TODO current implementation is too heavy.
        if($this->keyExists('status_data')) {
            /* @var \Stock\Model\StockStatusModel $currentStatusItem */
            $currentStatusItem = $this->getData('status_data')->firstItem();

            $currentStatusItem->getStatusCode();
            $statusOptions['current']['label'] = "Current";
            $statusOptions['current']['options'] = $currentStatusItem->getStatusCurrentWithLabel($currentStatusItem->getStatusCode());
            $statusOptions['available']['label'] = "Available";
            $statusOptions['available']['options'] = $currentStatusItem->getStatusAvailableWithLabels($currentStatusItem->getStatusCode());
//            var_dumP($statusOptions);

            $formOptions['fieldset_status']['status_code'] = $statusOptions;

            $form = $this->getWriteForm();
            $form->get('fieldset_status')->get('status_code')->setValueOptions($statusOptions);

            $this->addData($form,'form');

        } else {
            // form status does not exists yet

            $form = $this->getWriteForm();

            $this->addData($form,'form');
        }



        if(strtoupper($request->getMethod())==="POST") {
            // Form has been submitted

            $postData = $request->getParsedBody();

            $this->getData('form')->setData($postData);

            if ($this->getData('form')->isValid()) {
                // Form is valid
                $formData = $this->getData('form')->getData();

                $rowsAffected = $this->getStockService()->addStockProduct($formData);

                if($rowsAffected['rows_affected']['product']!==0
                    ||$rowsAffected['rows_affected']['stock']
                    ||$rowsAffected['rows_affected']['barcode']
                    ||$rowsAffected['rows_affected']['status']
                ) {
                    $messages['success'][] = 'Item has been updated.';
                } else {
                    $messages['info'][] = 'Data unchanged.';
                    $messages['info'][] = 'Item has NOT been updated.';
                }
            } else {
                $messages['error'][] = 'Form seems to be invalid.';
                $messages['error'][] = 'Item has NOT been updated.';
            }

        } elseif($this->currentProductUid) {
            // assume UPDATE
            $model = new \Stock\Model\StockWriteModel([
                'fieldset_product'=>$this->getData('product_data')->toArray(),
                'fieldset_stock'=>$this->getData('stock_data')->toArray(),
                'fieldset_barcode'=>$this->getData('barcode_data')->toArray(),
                'fieldset_status'=>$this->getData('status_data')->firstItem(),
            ]);

            $this->getData('form')->setData($model->toArray());

        }

        $this->addData($messages,'messages');

        return new HtmlResponse($this->template->render('stock::stock-product-write', $this->getData()));
    }

    /**
     * @return StockBarcodeForm
     */
    private function getWriteForm()
    {
        $form = new StockProductForm();
        if($this->currentProductUid) {
            $form->setAttribute(
                'action',
                $this->urlHelper->generate(
                    'stock.product.write.update.post',
                    ['product_uid'=>$this->currentProductUid]
                )
            );
        } else {
            $form->setAttribute(
                'action',
                $this->urlHelper->generate(
                    'stock.product.write.create.post'
                )
            );
        }


        return $form;
    }
}
