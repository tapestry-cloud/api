<?php

namespace TapestryCloud\Api\Tests;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TapestryCloud\Api\App;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\ServerRequestFactory;

class ApiTest extends \PHPUnit_Framework_TestCase
{

    /** @var App */
    protected $app;

    /** @var TestEmitter */
    protected $emitter;

    public function setUp()
    {
        $this->bootApp();
    }

    protected function bootApp()
    {
        $this->emitter = new TestEmitter();
        $this->app = new App(__DIR__ . '/mock_project/config.php', $this->emitter);

        $this->app->register(new \TapestryCloud\Api\Services\Routes);
        $this->app->register(new \TapestryCloud\Api\Services\Configuration);
        $this->app->register(new \TapestryCloud\Api\Services\Tapestry);
        $this->app->register(new \TapestryCloud\Database\ServiceProvider);
    }

    protected function runRequest(ServerRequest $request)
    {
        $this->app->run($request);
        return (string) $this->emitter->getResponse()->getBody();
    }

    /**
     * Test route: /
     */
	public function testIndex()
    {
        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST' => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/',
        ], [], [], [], []));

        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/json/index.json', $response);
    }

    /**
     * Test route: /content-types
     */
    public function testContentTypesIndex()
    {
        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST' => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/content-types',
        ], [], [], [], []));

        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/json/content-types.json', $response);
    }

    /**
     * Test route: /content-types
     */
    public function testContentTypeView()
    {
        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST' => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/content-type/1',
        ], [], [], [], []));

        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/json/content-type-1.json', $response);

        $this->bootApp();

        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST' => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/content-type/2',
        ], [], [], [], []));

        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/json/content-type-2.json', $response);
    }
}