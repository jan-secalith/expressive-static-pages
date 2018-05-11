<?php

declare(strict_types=1);

namespace Common\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Common\Model\StaticPageViewModel;
use Zend\Expressive\Flash\FlashMessageMiddleware;

class StaticPageHandler implements RequestHandlerInterface
{
    private $containerName;

    private $router;

    private $template;

    private $urlHelper;

    private $viewTemplateModel;



    public function __construct(
        Router\RouterInterface $router,
        Template\TemplateRendererInterface $template = null,
        string $containerName,
        UrlHelper $urlHelper = null,
        StaticPageViewModel $viewTemplateModel = null
    ) {
        $this->router        = $router;
        $this->template      = $template;
        $this->containerName = $containerName;
        $this->urlHelper = $urlHelper;
        $this->viewTemplateModel = $viewTemplateModel;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $data = null;

        $data['layout'] = $this->viewTemplateModel->getLayout();

        return new HtmlResponse($this->template->render($this->viewTemplateModel->getTemplate(), $data));
    }

}
