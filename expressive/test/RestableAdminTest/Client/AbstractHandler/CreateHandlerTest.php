<?php
namespace RestableAdminTest\Client\AbstractHandler;

use Common\Handler\CreateHandler;
use Common\Handler\Factory\CreateHandlerAbstractFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\Router\RouterInterface;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Zend\Diactoros\ServerRequest;

class CreateHandlerTest extends AbstractHttpControllerTestCase
{

    protected $container;
    protected $app;

    protected function setUp()
    {
        $this->container = require 'config/container.php';
        $this->app = $this->container->get(\Zend\Expressive\Application::class);

    }
    public function testRoutingWithMultipleMethodsSamePath()
    {
        $app = $this->app;

        $request  = new ServerRequest([], [], '/foo/bar', 'GET');
        $result   = $app->process($request, $this->container->get('RestableAdmin\Handler\CRUD\CreateHandler')->reveal());

        $this->assertEquals(
            '{success: true}',
            (string) $result->getBody()
        );
    }
}