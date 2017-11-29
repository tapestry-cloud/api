<?php

namespace TapestryCloud\Api\Tests;

use TapestryCloud\Api\App;
use Zend\Diactoros\ServerRequest;

class BootsApp extends \PHPUnit_Framework_TestCase
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
        return (string)$this->emitter->getResponse()->getBody();
    }
}