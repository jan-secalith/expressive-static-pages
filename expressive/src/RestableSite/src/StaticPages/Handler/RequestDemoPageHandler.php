<?php

declare(strict_types=1);

namespace RestableSite\StaticPages\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RestableSite\StaticPages\Form\RequestDemoForm;
use RestableSite\StaticPages\Model\RequestDemoFormTable;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Http\PhpEnvironment\Request as HttpRequest;

class RequestDemoPageHandler implements RequestHandlerInterface
{
    private $containerName;

    private $router;

    private $template;

    private $tableService;

    private $httpRequest;

    public function __construct(
        Router\RouterInterface $router,
        Template\TemplateRendererInterface $template = null,
        string $containerName,
        RequestDemoFormTable $tableService = null
    ) {
        $this->router        = $router;
        $this->template      = $template;
        $this->containerName = $containerName;
        $this->tableService  = $tableService;
        $this->httpRequest = new HttpRequest();
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $data = null;

        $data['layout'] = 'restablesite-layout::restable-site';

        $data['forms']['form_request_demo'] = $this->getRequestDemoForm();

        $clientIP = $this->httpRequest->getServer('REMOTE_ADDR');

        $dateTime = new \DateTime('20 minute ago');

        $count = $this->tableService->fetchByIpAndDateCount($clientIP,$dateTime->format('Y-m-d\TH:i:s.u'));

        if( $count  > 0 ) {
            return new HtmlResponse($this->template->render('staticpages::page-request-demo-success', $data));
        }

        if(strtoupper($request->getMethod())==="POST") {

            $formData = $request->getParsedBody();

            $data['forms']['form_request_demo']->setData($formData);

            if ($data['forms']['form_request_demo']->isValid()) {

                $filteredData = $data['forms']['form_request_demo']->getData();

                $filteredData->setIP($clientIP);

                $this->tableService->saveItem($filteredData);

                return new HtmlResponse($this->template->render('staticpages::page-request-demo-success', $data));

            } else {
                $messages = $data['forms']['form_request_demo']->getMessages();
//                var_dump($messages);
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
