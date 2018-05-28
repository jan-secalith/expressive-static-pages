<?php

declare(strict_types=1);

namespace RestableAdmin\Handler;

use Authentication\Service\AuthManager;
use Common\Handler\ApplicationConfigAwareInterface;
use Common\Handler\ApplicationConfigAwareTrait;
use Common\Handler\ApplicationFormAwareInterface;
use Common\Handler\ApplicationFormAwareTrait;
use Common\Handler\DataAwareInterface;
use Common\Handler\DataAwareTrait;
use Product\Service\ProductService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Stock\Form\StockProductForm;
use Stock\Service\StockService;
use Zend\Authentication\AuthenticationService;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Router;
use Zend\Expressive\Template;

class AuthLoginHandler implements RequestHandlerInterface,
    DataAwareInterface,
    ApplicationConfigAwareInterface,
    ApplicationFormAwareInterface
{
    use ApplicationConfigAwareTrait;
    use DataAwareTrait;
    use ApplicationFormAwareTrait;

    private $containerName;

    private $authService;

    private $authManager;

    private $router;

    private $template;

    private $urlHelper;

    private $currentProductUid;

    public function __construct(
        Router\RouterInterface $router,
        Template\TemplateRendererInterface $template = null,
        string $containerName,
        AuthenticationService $authService = null,
        AuthManager $authManager = null,
        UrlHelper $urlHelper = null
    ) {
        $this->router        = $router;
        $this->template      = $template;
        $this->containerName = $containerName;
        $this->authService = $authService;
        $this->authManager = $authManager;
        $this->urlHelper = $urlHelper;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $handlerConfig = $this->getData('handler_config');
        $this->addData($handlerConfig['view_template_model']['layout'],'layout');
        $messages = null;

        // Pass the forms (set by ApplicationFormAwareDelegator) to the View
        if(array_key_exists('forms',$handlerConfig) && ! empty($handlerConfig['forms'])) {
            $this->setData($this->getForms(),'forms');
        }


        if(strtoupper($request->getMethod())==="POST") {
            // Form has been submitted

            $postData = $request->getParsedBody();

            $loginForm = $this->getForm('form_login');

            $loginForm->setData($postData);

            if ($loginForm->isValid()) {
                // Form is valid
                $formData = $loginForm->getData();

//                $this->authManager->getAdapter()
//                    ->setEmail($formData['email'])
//                    ->setPassword($formData['password']);

//                $result = $this->authService->authenticate();
                $result = $this->authManager->login($formData['email'],$formData['password'],$formData['remember_me']);

                var_dump($result);
            } else {
                $messages['error'][] = 'Form seems to be invalid.';
                $messages['error'][] = 'Item has NOT been updated.';
            }

        }

        $this->addData($messages,'messages');

        return new HtmlResponse($this->template->render($handlerConfig['view_template_model']['template'], $this->getData()));
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
