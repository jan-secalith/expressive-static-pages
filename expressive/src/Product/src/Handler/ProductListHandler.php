<?php

declare(strict_types=1);

namespace Product\Handler;

use Common\Helper\RouteHelper;
use Cart\Form\ItemAddForm;
use Cart\Form\CartAccessForm;
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

    private $cartService;

    private $currencyExchangeService;

    private $urlHelper;

    protected $useCurrencyExchange;
    protected $useCurrencyExchangeForm;

    public function __construct(
        Router\RouterInterface $router,
        Template\TemplateRendererInterface $template = null,
        string $containerName,
        ProductService $productService = null,
        CartService $cartService = null,
        UrlHelper $urlHelper = null
    ) {
        $this->router        = $router;
        $this->template      = $template;
        $this->containerName = $containerName;
        $this->productService = $productService;
        $this->cartService = $cartService;
        $this->urlHelper = $urlHelper;

        $this->useCurrencyExchange = true;
        $this->useCurrencyExchangeForm = true;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $data = null;

        $data['layout'] = 'layout::ecommerce';

        $productList = $this->productService->getItems();

        $prgData = $request->getAttribute('prg');

        if(strtoupper($request->getMethod())==="POST") {
            $postData = $request->getParsedBody();
        } elseif (false !== $prgData || ! empty($prgData)) {
//            var_dump($prgData);
            $postData = $prgData;
        } else {
            $postData = [];
        }

        if( $this->cartService!==null&&$this->cartService->allowCartUse() === true ) {
            if (! empty($productList)) {
                /* @var \Product\Model\ProductModel $product */
                foreach($productList as $product) {
                    // Attach Forms to the Product
                    $data['forms']['id_' . $product->getProductUid()] = [
                        'product_uid' => $product->getProductUid(),
                        'form' => [
//                            'cart_product_add' => $this->getFormCartProductAdd($product),
                        ],
                    ];
                }
            }

            $data['forms']['form_cart_access'] = $this->getCartAccessForm();

        }

        $data['list'] = $productList;

//        $flashMessages = $request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);
//        $data['messages'] = $flashMessages->getFlashes();

        return new HtmlResponse($this->template->render('product::product-list', $data));
    }

    /**
     * @return CartAccessForm
     */
    private function getCartAccessForm()
    {
        $form = new CartAccessForm();
        $form->setAttribute('action', $this->urlHelper->generate('cart.list.post'));

        return $form;
    }
}
