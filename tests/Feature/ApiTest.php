<?php

namespace TapestryCloud\Api\Tests\Feature;

use TapestryCloud\Api\Tests\BootsApp;
use Zend\Diactoros\ServerRequestFactory;

class ApiTest extends BootsApp
{

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

        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/../json/index.json', $response);
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

        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/../json/content-types.json', $response);
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

        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/../json/content-type-1.json', $response);

        $this->bootApp();

        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST' => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/content-type/2',
        ], [], [], [], []));

        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/../json/content-type-2.json', $response);
    }
}