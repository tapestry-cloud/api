<?php

namespace TapestryCloud\Api\Tests;

use League\Container\Container;
use League\Event\Emitter;
use League\Route\RouteCollection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TapestryCloud\Api\App;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\EmitterInterface;
use Zend\Diactoros\ServerRequestFactory;

class ApplicationClassTest extends \PHPUnit_Framework_TestCase
{
    protected $response;
    protected $request;

    public function setUp()
    {
        $this->request = $this->createMock(ServerRequestInterface::class);
        $this->response = $this->createMock(ResponseInterface::class);
    }

    public function testInstances()
    {
        $emitter = $this->createMock(EmitterInterface::class);
        $app = new App(__DIR__.'/../mock_project/config.php', $emitter);
        $this->assertTrue($app->getContainer() instanceof Container);
        $this->assertTrue($app->getRouter() instanceof RouteCollection);
        $this->assertTrue($app->getEmitter() instanceof Emitter);
    }

    public function testAppEmitsOnRun()
    {
        $emitter = $this->createMock(EmitterInterface::class);
        $emitter->expects($this->once())->method('emit');

        $app = new App(__DIR__.'/../mock_project/config.php', $emitter);
        $app->get('/', function (ServerRequestInterface $request, ResponseInterface $response) {
            return $response;
        });
        $app->run();
    }

    public function testRouteDispatch()
    {
        $emitter = new TestEmitter();
        $app = new App(__DIR__.'/../mock_project/config.php', $emitter);

        $invoked = false;

        $app->get('/foo/bar', function (ServerRequestInterface $request, ResponseInterface $response) use (&$invoked) {
            $invoked = true;

            return $response;
        });

        $request = ServerRequestFactory::fromGlobals([
            'HTTP_HOST'      => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI'    => '/foo/bar',
            'QUERY_STRING'   => 'bar=baz',
        ], [], [], [], []);

        /* @var Response $response */
        $app->run($request);
        $this->assertTrue($invoked);
    }
}
