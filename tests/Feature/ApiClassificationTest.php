<?php

namespace TapestryCloud\Api\Tests\Feature;

use TapestryCloud\Api\Tests\BootsApp;
use Zend\Diactoros\ServerRequestFactory;

class ApiClassificationTest extends BootsApp
{

    /**
     * Test route: /classifications
     */
    public function testClassificationIndex()
    {
        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST' => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/classifications',
        ], [], [], [], []));

        $this->assertResponseOk();
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/../json/classifications.json', $response);
    }

    /**
     * Test route: /classification/{id}
     */
	public function testClassificationView()
    {
        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST' => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/classification/1',
        ], [], [], [], []));

        $this->assertResponseOk();
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/../json/classification-1.json', $response);
    }

    /**
     * Test route: /classification/{id}/taxonomy
     */
    public function testClassificationTaxonomy()
    {
        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST' => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/classification/1/taxonomy',
        ], [], [], [], []));

        $this->assertResponseOk();
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/../json/classification-1-taxonomy.json', $response);
    }

    /**
     * Test route: /classification/{id}/files
     */
    public function testClassificationFiles()
    {
        $response = $this->runRequest(ServerRequestFactory::fromGlobals([
            'HTTP_HOST' => 'example.com',
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/classification/1/files',
        ], [], [], [], []));

        $this->assertResponseOk();
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/../json/classification-1-files.json', $response);
    }
}