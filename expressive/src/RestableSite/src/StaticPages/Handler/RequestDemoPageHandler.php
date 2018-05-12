<?php

declare(strict_types=1);

namespace RestableSite\StaticPages\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use RestableSite\StaticPages\Form\RequestDemoForm;

class RequestDemoPageHandler implements RequestHandlerInterface
{
    private $containerName;

    private $router;

    private $template;

    public function __construct(
        Router\RouterInterface $router,
        Template\TemplateRendererInterface $template = null,
        string $containerName
    ) {
        $this->router        = $router;
        $this->template      = $template;
        $this->containerName = $containerName;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $data = null;

        $data['layout'] = 'restablesite-layout::restable-site';

        $data['forms']['form_request_demo'] = $this->getRequestDemoForm();

        if(strtoupper($request->getMethod())==="POST") {

            $formData = $request->getParsedBody();

            $data['forms']['form_request_demo']->setData($formData);

            if ($data['forms']['form_request_demo']->isValid()) {
//
                $filteredData = $data['forms']['form_request_demo']->getData();

//                var_dump($filteredData);

//                return new HtmlResponse($this->template->render('staticpages::page-request-demo-success', $data));

            } else {
                $messages = $data['forms']['form_request_demo']->getMessages();
                var_dump($messages);
            }
        }

        return new HtmlResponse($this->template->render('staticpages::page-request-demo', $data));

    }

    private function getRequestDemoForm()
    {
        $form = new RequestDemoForm();

//        $form->setAttribute('action', $this->urlHelper->generate('restable.site.page.request_demo'));

        $form->setAttribute('method', 'POST');

        return $form;
    }
}
