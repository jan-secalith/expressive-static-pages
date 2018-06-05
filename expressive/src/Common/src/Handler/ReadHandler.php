<?php

declare(strict_types=1);

namespace Common\Handler;

use Common\Handler\DataAwareInterface;
use Common\Handler\DataAwareTrait;
use Common\Paginator\PaginatorAwareInterface;
use Common\Paginator\PaginatorAwareTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Paginator\Paginator;
use Zend\Paginator\ScrollingStyle\Sliding;

class ReadHandler implements RequestHandlerInterface, DataAwareInterface
{
    use DataAwareTrait;

    private $containerName;

    private $router;

    private $template;

    private $resources;

    private $urlHelper;

    public function __construct(
        Router\RouterInterface $router,
        Template\TemplateRendererInterface $template = null,
        string $containerName,
        array $resources = [],
        UrlHelper $urlHelper = null
    ) {
        $this->router        = $router;
        $this->template      = $template;
        $this->containerName = $containerName;
        $this->addData($resources,'resources');
        $this->urlHelper = $urlHelper;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        return new HtmlResponse($this->template->render($this->getData('template'), $this->getData()));
    }
}
