<?php

namespace TapestryCloud\Api\Tests\Feature;

use TapestryCloud\Api\Tests\BootsApp;
use Zend\Diactoros\ServerRequestFactory;

class ApiIndexTest extends BootsApp
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

        $this->assertResponseOk();
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/../json/index.json', $response);
    }
}