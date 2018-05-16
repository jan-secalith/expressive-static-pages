<?php

declare(strict_types=1);

namespace Stock\Handler;

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

class StockWriteHandler implements RequestHandlerInterface, StockServiceAwareInterface
{

    use StockServiceAwareTrait;

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

        $data['layout'] = 'restable-stock-layout::restable-stock';

        $this->currentProductUid = $request->getAttribute('product_uid');

        $requestedProductUid = $request->getAttribute('product_uid');

        $data['product_data'] = $this->productService->getItem($requestedProductUid);
        $data['stock_data'] = $this->getStockService()->getItem($requestedProductUid);

        $data['form'] = $this->getWriteForm();

        if(strtoupper($request->getMethod())==="POST") {
            $postData = $request->getParsedBody();

            $data['form']->setData($postData);

            if ($data['form']->isValid()) {

                $formData = $data['form']->getData();

//                $this->productService->addProduct($formData);
//                $this->getStockService()->addStock($formData);
                $this->getStockService()->addStockProduct($formData);

            } else {
                print_r($data['form']->getMessages());
            }

        } else {
            $model = new \Stock\Model\StockWriteModel([
                'fieldset_product'=>$data['product_data']->toArray(),
                'fieldset_stock'=>$data['stock_data']->toArray(),
            ]);

            $data['form']->setData($model->toArray());
        }

        return new HtmlResponse($this->template->render('stock::stock-product-write', $data));
    }

    /**
     * @return StockBarcodeForm
     */
    private function getWriteForm()
    {
        $form = new StockProductForm();
        $form->setAttribute(
            'action',
            $this->urlHelper->generate(
                'stock.product.write.post',
                ['product_uid'=>$this->currentProductUid]
            )
        );

        return $form;
    }
}
